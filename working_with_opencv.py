import pytesseract
import PIL
import cv2
from matplotlib import pyplot as plt
pytesseract.pytesseract.tesseract_cmd=r"C:\Program Files\Tesseract-OCR\tesseract.exe"
#OPENING AN IMAGE
image='GLA_University_logo.png'
img=cv2.imread(image)
def display_image_in_actual_size(im_path):

    dpi = 80
    im_data = plt.imread(im_path)
    height, width, depth = im_data.shape

    # What size does the figure need to be in inches to fit the image?
    figsize = width / float(dpi), height / float(dpi)

    # Create a figure of the right size with one axes that takes up the full figure
    fig = plt.figure(figsize=figsize)
    ax = fig.add_axes([0, 0, 1, 1])

    # Hide spines, ticks, etc.
    ax.axis('off')

    # Display the image.
    ax.imshow(im_data, cmap='gray')

    plt.show()
display_image_in_actual_size(image)
#INVERTED IMAGES
inverted_image=cv2.bitwise_not(img)
cv2.imwrite("temp/inverted.jpg",inverted_image)
display_image_in_actual_size("temp/inverted.jpg")
#BINARIZATION
def grayscale(image):
    return cv2.cvtColor(image,cv2.COLOR_BGR2GRAY)
gray_image=grayscale(img)
cv2.imwrite("temp/gray.jpg",gray_image)
#display_image_in_actual_size("temp/gray.jpg")
#ACTUALLY CONVERTING IMAGE TO BLACK AND WHITE
thresh, im_bw=cv2.threshold(gray_image,127,255,cv2.THRESH_BINARY)
cv2.imwrite("temp/bw_image.jpg", im_bw)
#display_image_in_actual_size("temp/bw_image.jpg")
#NOISE REMOVAL
def noise_removal(image):
    import numpy as np
    kernel=np.ones((1, 1),np.uint8)
    image=cv2.dilate(image,kernel,iterations=1)
    kernel=np.ones((1, 1),np.uint8)
    image=cv2.erode(image,kernel,iterations=1)
    image=cv2.morphologyEx(image,cv2.MORPH_CLOSE,kernel)
    image=cv2.medianBlur(image, 3)
    return (image)
no_noise=noise_removal(im_bw)
cv2.imwrite("temp/no_noise.jpg",no_noise)
#display_image_in_actual_size("temp/no_noise.jpg")
