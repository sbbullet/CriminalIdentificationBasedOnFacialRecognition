# from PIL import Image
# from io import BytesIO
# import base64


# def pil_image_to_base64(pil_image):
#     buf = BytesIO()
#     pil_image.save(buf, format="JPEG")
#     return base64.b64encode(buf.getvalue())


# def base64_to_pil_image(base64_img):
#     return Image.open(BytesIO(base64.b64decode(base64_img)))


from PIL import Image
from io import BytesIO
import base64
import cv2
import numpy as np


def pil_image_to_base64(pil_image):
    buf = BytesIO()
    pil_image.save(buf, format="JPEG")
    return base64.b64encode(buf.getvalue())


def base64_to_pil_image(base64_img):
    return Image.open(BytesIO(base64.b64decode(base64_img)))

def cv2_to_base64(cv2_img):
    _,image = cv2.imencode('.jpg',cv2_img)
    return base64.b64encode(image)

def pil_image_to_cv2(img):
    frame = np.array(img)
    frame = cv2.cvtColor(frame, cv2.COLOR_RGB2BGR)
    return frame

def cv2_to_pil_image(cv2_img):
    _,image = cv2.imencode('.jpg',cv2_img)
    base64_img = base64.b64encode(image)
    return Image.open(BytesIO(base64.b64decode(base64_img)))



# def base64_to_cv2(base64_img):
#     # nparr = np.fromstring(base64_img.decode('base64'), np.uint8)
#     nparr = np.fromstring(base64_img.decode('base64'), np.uint8)
#     return cv2.imdecode(nparr)
