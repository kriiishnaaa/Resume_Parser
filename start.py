import cv2
from PIL import Image
import pytesseract
pytesseract.pytesseract.tesseract_cmd=r"C:\Program Files\Tesseract-OCR\tesseract.exe"
img='C:\xampp\htdocs\OCR\WhatsApp Image 2023-07-26 at 12.04.36 PM.jpeg'
def ocr_image(img):
    text=pytesseract.image_to_string(img)
    return text
im=Image.open(img)
ocrresult=pytesseract.image_to_string(img)
print(ocrresult)
# print(ocr_image(img))
