from PIL import Image
from embedding_generator import get_embedding
from entry import *
from utils import *
# true_positive = 1
import time

class Makeup_artist(object):
    def __init__(self):
        pass

    def apply_makeup(self, img):
        # socketio.emit('hello', {'data':'mellow'}, namespace='/test')
        # return img.transpose(Image.FLIP_LEFT_RIGHT)
        
        frame = pil_image_to_cv2(img)
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        dets = detector(gray, 0)
        # dict_empty=True
        
        if dets:
            
            # face_distances={}
            for k, d in enumerate(dets):
                face_distances={}
                crop_img = frame[d.top():d.bottom(), d.left():d.right()]
                # cv2.imwrite('face_detected_' + str(true_positive) +'cropped' + '_' + str(k) + '.jpg', crop_img)

                # img = image_loader('face_detected_' + str(true_positive) +'cropped' + '_' + str(k) + '.jpg')
                img = image_loader(crop_img)
                embedding = get_embedding(img)
                for id,face_embedding in known_faces.items():
                    dict_empty=True
                    # See if the face is a match for the known face(s)
                    distance = l2_distance.forward(embedding, face_embedding)  # Euclidean distance
                    distance = distance.cpu().detach().numpy()
                    if distance <= threshold:
                        face_distances[id]=distance
                        dict_empty = False
                if (not dict_empty):
                    closest_id = min(face_distances, key=face_distances.get)
                    print('detected one suspect: ', closest_id)
                    # print('closesta match:'+ closest_match)
                    # true_positive += 1
                    socketio.emit('suspect detected', {'id': closest_id}, namespace='/test')

    #                 cv2.putText(gray,closest_match,(d.left(),d.top()), font, 0.5,(255,0,0),2)

                cv2.rectangle(gray, (d.left(),d.top()), (d.right(), d.bottom()), (255, 0, 0), 2) #255,0,0 for rgb, 2 for width
#             cv2.putText(gray,closest_match,(d.left(),d.top()), font, 0.5,(255,0,0),2)
        return (gray)

