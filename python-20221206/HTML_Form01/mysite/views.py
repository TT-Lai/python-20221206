from django.shortcuts import render
from mysite import models
from django.template.loader import get_template
from django.http import HttpResponse

# Create your views here.

def index(request, pid=None, del_pass=None):
    #template = get_template('index.html')
    posts = models.Post.objects.filter(enabled=True).order_by('-pub_time')[:30]
    moods = models.Mood.objects.all()
    try:
        user_id = request.GET['user_id']
        user_pass = request.GET['user_pass']
        user_post = request.GET['user_post']
        user_mood = request.GET['mood']
    except:
        user_id = None
        message = '如要張貼訊息，則每一個欄位都要填...'
    #if user_id != None:
    #    mood = models.Mood.objects.get(status=user_mood)
    #    post = models.Post.objects.create(mood=mood, nickname=user_id, del_pass=user_pass, message=user_post)
    #    post.save()
    if del_pass and pid:
        try:
            post = models.Post.objects.get(id=pid)
        except:
            post = None
        if post:
            if post.del_pass == del_pass:
                post.delete()
                message = "資料刪除成功"
            else:
                message = "密碼錯誤"
    elif user_id != None:
        mood = models.Mood.objects.get(status=user_mood)
        post = models.Post.objects.create(mood=mood, nickname=user_id, del_pass=user_pass, message=user_post)
        post.save()
        message='成功儲存！請記得你的編輯密碼[{}]!，訊息需經審查後才會顯示。'.format(user_pass)
#    urfcolor = request.GET.getlist('fcolor')
#    se_byear = request.GET['byear']    
    return render(request, 'index.html', locals())








"""    try:
        urid = request.GET['user_id']
        urpass = request.GET['user_pass']
        years = range(1960,2022) 
    except:
        urid = None
    if urid != None and urpass == '12345':
        verified = True
    else:
        verifeid = False"""


#def index(request):
#    template = get_template('index.html')
#    try:
#        urid = request.GET['user_id']
#        urpass = request.GET['user_pass']
#    except:
#        urid = None
#    return render(request, 'index.html', locals())