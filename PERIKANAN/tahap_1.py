import os
import re
from openpyxl import load_workbook

excel_file = "DRP AdHoc Perikanan 2025.xlsx"
output_folder = "gambar_excel"
os.makedirs(output_folder, exist_ok=True)

wb = load_workbook(excel_file, data_only=True)
count = 0

for sheet in wb.worksheets:
    images_with_pos = []
    if hasattr(sheet, "_images"):
        for image in sheet._images:
            row = None
            try:
                anchor = image.anchor
                if hasattr(anchor, "_from"):  # versi baru openpyxl
                    row = anchor._from.row + 1
                elif hasattr(anchor, "from_"):  # versi lama
                    row = anchor.from_.row + 1
                elif isinstance(anchor, str):
                    match = re.match(r"[A-Z]+(\d+)", anchor)
                    if match:
                        row = int(match.group(1))
            except Exception:
                pass

            if hasattr(image, "_data"):
                images_with_pos.append((image, row if row else 999999))

        # Urutkan berdasarkan posisi baris
        images_with_pos.sort(key=lambda x: x[1])

        # Simpan gambar berurutan
        for idx, (image, row) in enumerate(images_with_pos, start=1):
            filename = f"{sheet.title}_gambar_{idx}.png"
            path = os.path.join(output_folder, filename)
            with open(path, "wb") as f:
                f.write(image._data())
            count += 1
            print(f"✔ {filename} (baris {row})")

print(f"\nTotal gambar disimpan: {count}")
