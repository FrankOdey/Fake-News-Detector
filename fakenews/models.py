from django.db import models

# Create your models here.
class Url(models.Model):
	Url = models.CharField(max_length=300, help_text="Analyzed Url")
	Title = models.TextField(default='None')
	Text = models.TextField(default='None')
	Classification = models.CharField(max_length=4)
	Voting = models.IntegerField()