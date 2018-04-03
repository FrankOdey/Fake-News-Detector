from django.db import models
from django.contrib.auth.models import User
# Create your models here.
class Url(models.Model):
	Url = models.CharField(max_length=300, help_text="Analyzed Url")
	Title = models.TextField(default='None')
	Text = models.TextField(default='None')
	Classification = models.CharField(max_length=4)
	Likes = models.IntegerField(default='0')
	Dislikes = models.IntegerField(default='0')
	Rating = models.DecimalField(max_digits=3,default='0',decimal_places=2)
	users = models.ManyToManyField(User, through='Vote')


class Vote(models.Model):
	url = models.ForeignKey(Url, on_delete=models.CASCADE)
	user = models.ForeignKey(User, on_delete=models.CASCADE)
	Like = models.BooleanField(default='False')
	Dislike = models.BooleanField(default='False')