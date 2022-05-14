from entry import *
# from entry import np,cv2
import numpy as np
import cv2
from app import *


# def get_embedding(img, id):
#     frame = np.array(img)
#     frame = cv2.cvtColor(frame, cv2.COLOR_RGB2BGR)
#     # print(frame)
#     gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
#     print('gray: ', gray)
#     print("model", model)
#     dets = detector(gray, 1)
#     if dets:
#         for k, d in enumerate(dets):
#             crop_img = frame[d.top():d.bottom(), d.left():d.right()]
#             cv2.imwrite(str(id) +'cropped' + '_' + str(k) + '.jpg', crop_img)
#             img = image_loader(str(id) +'cropped' + '_' + str(k) + '.jpg')
#             model.eval() #try removing this
#             with torch.no_grad():
#                 id_embed = model(img)
#                 known_faces[id] = id_embed
#                 listed = id_embed.tolist()
#                 print('list: ', listed)
#                 socketio.emit('generated embedding', { 'embedding': listed, 'id': id}, namespace='/test')
#             # print("id_embed==", id_embed)
#             print("known_faces==", known_faces)
#     return ('hello world')
        

def get_embedding(img):
    model.eval()
    with torch.no_grad():
        return(model(img))

