from django.shortcuts import render
from django.shortcuts import redirect
import predict_pickle
from newspaper import Article

from django.contrib.auth.forms import UserCreationForm
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login , logout
from django import forms
from .models import Url

class SignUpForm(UserCreationForm):
    first_name = forms.CharField(max_length=30, required=False, help_text='Optional.')
    last_name = forms.CharField(max_length=30, required=False, help_text='Optional.')
    email = forms.EmailField(max_length=254, help_text='Required. Inform a valid email address.')

    class Meta:
        model = User
        fields = ('username', 'first_name', 'last_name', 'email', 'password1', 'password2', )

def signup(request):
    if request.method == 'POST':
        form = SignUpForm(request.POST)
        if form.is_valid():
            form.save()
            username = form.cleaned_data.get('username')
            raw_password = form.cleaned_data.get('password1')
            user = authenticate(username=username, password=raw_password)
            login(request, user)
            return redirect('/')
    else:
        form = SignUpForm()
    return render(request, 'fakenews/signup.html', {'form': form})

# Create your views here.
def home(request):
    return render(request, 'fakenews/home.html' , {})

def classify(request):
    if request.method== "POST":
        result,features=predict_pickle.classify(request.POST['title'],request.POST['article'])

        print(result)
        print(features[0])

    return render(request, "fakenews/classify.html", {'result' : result, 'wordcount': features[0][0], 'titlecount':features[0][1], 'punccount': features[0][2], 'gunningfog': features[0][4], 'readability':features[0][5]})

def classify_url(request):
    if request.method=="POST":
        newsurl=request.POST['newsurl']
        article=Article(newsurl)
        article.download()
        article.parse()
        print(article.title)
        print(article.text)
        result, features = predict_pickle.classify(article.title, article.text)
        u1 = Url(Url=newsurl,Title=article.title,Text=article.text,Classification=result,Voting=0)
        u1.save()
        return render(request, "fakenews/classify.html", {'articletitle': article.title, 'articletext': article.text,'result': result, 'wordcount': features[0][0], 'titlecount':features[0][1], 'punccount': features[0][2], 'gunningfog': features[0][4], 'readability':features[0][5]})
def logout_view(request):
    logout(request)
    return redirect('/')

def register_view(request):
    title

def voting_view(request):
    urls = Url.objects.all()
    return render(request,"fakenews/voting.html",{'urls':urls})