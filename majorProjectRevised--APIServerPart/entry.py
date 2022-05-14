from sys import stdout
import logging
from flask import Flask
from flask_socketio import SocketIO, emit, send
from utils import *


import dlib
import cv2
import numpy as np
import os
import glob
import sys

from resnet import Resnet34Triplet
import torch 
import torch.nn as nn
import torchvision
import os
import torchvision.models as models
from PIL import Image
import matplotlib.pyplot as plt
from torchvision import transforms
from torch.nn.modules.distance import PairwiseDistance



from PIL import Image
device = torch.device("cuda" if torch.cuda.is_available() else "cpu")


# from resnet import Resnet34Triplet

# l2_distance = PairwiseDistance(2)
# threshold = 1.18

# ##################### Load Trained Model #########################
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
#transforms
loader =  transforms.Compose([
              transforms.Resize((250,250)),
              transforms.ToTensor(),
              transforms.Normalize(
                  mean=[0.5, 0.5, 0.5],
                  std=[0.5, 0.5, 0.5]
              )
            ])



# def image_loader(image_name):
#     """load image, returns cuda tensor"""
#     image = Image.open(image_name)   
#     image = loader(image)
#     image = image.to(device)
#     image = image[None]
#     image = image.type('torch.FloatTensor') # instead of DoubleTensor
    
#     return image


def image_loader(cv2_img):
        """load image, returns cuda tensor"""
        image = cv2_to_pil_image(cv2_img)
        image = loader(image)
        image = image.to(device)
        image = image[None]
        image = image.type('torch.FloatTensor') # instead of DoubleTensor
        
        return image
    





threshold = 1.18
known_faces = {}
face_distances = {}
true_positive = 1
l2_distance = PairwiseDistance(2)




app = Flask(__name__)
resume_path = '/home/mr-bullet/Desktop/Facedetection/MODEL/model_resnet34_triplet_newmew.pt'
cuda = torch.cuda.is_available()
if cuda:
        checkpoint = torch.load(resume_path)
else:
        checkpoint = torch.load(resume_path, map_location=lambda storage, loc: storage)
        

detector = dlib.get_frontal_face_detector()
embedding_dimension = 128
pretrained = True
print('model loading ....................')
model = Resnet34Triplet(embedding_dimension=embedding_dimension, pretrained=pretrained)
# model.load_state_dict(checkpoint['model_state_dict'])


device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
model.load_state_dict(checkpoint['model_state_dict'])
print('model loaded')

loader =  transforms.Compose([
          transforms.Resize((250,250)),
          transforms.ToTensor(),
          transforms.Normalize(
              mean=[0.5, 0.5, 0.5],
              std=[0.5, 0.5, 0.5]
          )
        ])

model.load_state_dict(checkpoint['model_state_dict'])
app.logger.addHandler(logging.StreamHandler(stdout))
app.config['SECRET_KEY'] = 'secret!'
app.config['DEBUG'] = True
socketio = SocketIO(app)

# if __name__ == "__main__":
#         print('from entry main')
#         socketio.run(app)