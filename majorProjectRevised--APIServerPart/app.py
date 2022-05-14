from sys import stdout
from makeup_artist import Makeup_artist
import logging
from flask import Flask, render_template, Response
from entry import *
from flask_socketio import SocketIO
from camera import Camera
from utils import base64_to_pil_image, pil_image_to_base64, pil_image_to_cv2
from embedding_generator import get_embedding
import time



import torch 
import torch.nn as nn
import torchvision
# import os
import torchvision.models as models
from PIL import Image
import matplotlib.pyplot as plt
from torchvision import transforms
from torch.nn.modules.distance import PairwiseDistance
from resnet import Resnet34Triplet



# l2_distance = PairwiseDistance(2)
# threshold = 1.18



camera = Camera(Makeup_artist())

@socketio.on('input image', namespace='/test')
def test_message(input):
    input = input.split(",")[1]
    camera.enqueue_input(input)
    #camera.enqueue_input(base64_to_pil_image(input))


@socketio.on('connect', namespace='/test')
def test_connect():
    app.logger.info("client connected")
    # print('threshold::', threshold)

@socketio.on('my event', namespace='/test')
def handle_my_event(json):
    print('received json: ' + str(json))


@socketio.on('all suspects', namespace='/test')
def handle_all_suspects(json):
    # print(json)
    try:
        for suspect in json:
            embedding_tensor = torch.FloatTensor(suspect['embedding'])
            known_faces[suspect['id']]= embedding_tensor
    except:
        print('error occured during populating known faces dict')



@socketio.on('add image', namespace='/test')
def handle_add_image(json):
    print('before addition:',known_faces)
    print('----------------------------------------------------------------------------------')
    input  = json['image']
    id = json['id']
    # print('id:', id)
    embedding = torch.rand(1,128)
    embedding_list=[]
    input_str = input.split(",")[1]
    input_img = base64_to_pil_image(input_str)
    frame = pil_image_to_cv2(input_img)
    # frame = np.array(input_img)
    # frame = cv2.cvtColor(frame, cv2.COLOR_RGB2BGR)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    dets = detector(gray, 0)
    if dets:
        for k, d in enumerate(dets):
            crop_img = frame[d.top():d.bottom(), d.left():d.right()]
            # cv2.imwrite(str(id) +'cropped' + '_' + str(k) + '.jpg', crop_img)
            # img = image_loader(str(id) +'cropped' + '_' + str(k) + '.jpg')
            img = image_loader(crop_img)
            embedding = get_embedding(img)
            embedding_list = embedding.tolist()                
        socketio.emit('generated embedding', { 'embedding': embedding_list, 'id': id}, namespace='/test')
        known_faces[id] = embedding
        print('after addition: ', known_faces)      

    else:
        print('embedding generation failed')
        socketio.emit('embedding generation failed', {'id':id}, namespace='/test')



# @app.route('/')
# def load_model():
    
    ##################### Load Trained Model #########################
    # resume_path = '/home/mr-bullet/Desktop/Facedetection/MODEL/model_resnet34_triplet_newmew.pt'
    # cuda = torch.cuda.is_available()
    # if cuda:
    #         checkpoint = torch.load(resume_path)
    # else:
    #         checkpoint = torch.load(resume_path, map_location=lambda storage, loc: storage)
            

    # detector = dlib.get_frontal_face_detector()
    # embedding_dimension = 128
    # pretrained = True
    # model = Resnet34Triplet(embedding_dimension=embedding_dimension, pretrained=pretrained)
    # # model.load_state_dict(checkpoint['model_state_dict'])


    # device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    # model.load_state_dict(checkpoint['model_state_dict'])

    # loader =  transforms.Compose([
    #           transforms.Resize((250,250)),
    #           transforms.ToTensor(),
    #           transforms.Normalize(
    #               mean=[0.5, 0.5, 0.5],
    #               std=[0.5, 0.5, 0.5]
    #           )
    #         ])




@app.route('/detection-zone')
def index():
    """Video streaming home page."""
    return render_template('index.html')


def gen():
    """Video streaming generator function."""
    app.logger.info("starting to generate frames!")
    while True:
        
        frame = camera.get_frame() #pil_image_to_base64(camera.get_frame())
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
        

@app.route('/video_feed')
def video_feed():
    """Video streaming route. Put this in the src attribute of an img tag."""
    return Response(gen(), mimetype='multipart/x-mixed-replace; boundary=frame')


print("from app.py::name::", __name__)

# if __name__ == '__main__':

#     # embedding_dimension = 128
#     # pretrained = True
#     # model = Resnet34Triplet(embedding_dimension=embedding_dimension, pretrained=pretrained)
#     # resume_path= '/home/mr-bullet/Desktop/Facedetection/MODEL/model_resnet34_triplet_newmew.pt'
#     # cuda = torch.cuda.is_available()
#     # if cuda:
#     #     checkpoint = torch.load(resume_path)
#     # else:
#     #     checkpoint = torch.load(resume_path, map_location=lambda storage, loc: storage)
        
#     # model.load_state_dict(checkpoint['model_state_dict'])
#     print('model loaded')
#     # detector = dlib.get_frontal_face_detector()

#     # device = torch.device("cuda" if torch.cuda.is_available() else "cpu")

#     # loader =  transforms.Compose([
#     #           transforms.Resize((250,250)),
#     #           transforms.ToTensor(),
#     #           transforms.Normalize(
#     #               mean=[0.5, 0.5, 0.5],
#     #               std=[0.5, 0.5, 0.5]
#     #           )
#     #         ])
#     socketio.run(app)
