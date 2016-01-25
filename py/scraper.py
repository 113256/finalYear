from urllib.request import urlopen
from bs4 import BeautifulSoup 
import re#regex 
import MySQLdb
import urllib.parse
import string
import json
from time import sleep


#find strings that are almost the same 
def fuzzy_match(s1, s2):
     return normalize(s1)==normalize(s2)

def normalize(s):
    s = "".join(l for l in s if l not in string.punctuation)
    return s.lower().strip().replace(" ", "")#strip() only removes leading and end whitespaces so we have to remove the ones in between using replace()
movieId = ""
def scrape(movieUrl):
     htmltext = urlopen(movieUrl).read().decode('utf-8')
     regex = '<a class="movielink" href="(.+?)">(.+?)</a>'
     #<a class="movielink" href="http://yify-movie.com/movie/jupiter-ascending-2015-720p/">Jupiter Ascending</a>
     #print (regex)
     pattern = re.compile(regex)
     movielist = re.findall(pattern, htmltext)#its a list since its findall, you cant do this print("price of "+ item+ " is "+pricelist), must get each element in list! 

     movieId = "" 
     conn = MySQLdb.connect(host = "localhost", user = "root", passwd = "", db="final year")

     for movie in movielist:

          #movieId +=1
          movieNameArray = movie[1].split()#split names with more than one word into array

          #if movie title has more than one word 
          if(len(movieNameArray)>1):
               urlMovieName = ""
               for movieSplitName in movieNameArray:
                    urlMovieName = urlMovieName+ movieSplitName+"+"
               urlMovieName = urlMovieName[:-1]#remove the last "+"
          else:
               urlMovieName = movieNameArray[0]
          movieId = urlMovieName     #unique identifier

          selectQuery = "SELECT movieId FROM moviename"
          x = conn.cursor()
          x.execute(selectQuery)
          #conn.commit() 
          exists = 0
          data = x.fetchall()
          for row in data :
              #ROW IS TUPLE SO NEED TO DO ROW[0]
              #print(row[0])
              #print(movieId)
              if fuzzy_match(row[0], movieId):
                  print("FOUND") 
                  exists = 1#already exists in table
                  break 


          if exists == 1:
               print ("exists!")
               continue        
          else:
               print("not found")
               insertQuery = "INSERT IGNORE INTO moviename (movieId, name) VALUES ( %s, %s)"
               x = conn.cursor()
               x.execute(insertQuery, (movieId, movie[1]))
               conn.commit() 

               #movie[0] is link movie[1] is name (See regex, there are 2 instances of (.+?) - '<a class="movielink" href="(.+?)">(.+?)</a>'
               movieText = urlopen(movie[0]).read().decode('utf-8')
               
               #links
               soup = BeautifulSoup(movieText, "html.parser")
               
               youtubeLink = ""
               for tag in soup.findAll('a', { "class" : "button yt-btn" }):
                    youtubeLink = tag['href']

               imdbLink = ""
               for tag in soup.findAll('a', { "class" : "button imdb-btn" }):
                    imdbLink = tag['href']

               tmdbLink=""
               for tag in soup.findAll('a', { "class" : "button tmdb-btn" }):
                    tmdbLink = tag['href']


               
               
               
             


               rated = ""
               releaseDate = ""
               runtime = ""
               genre = ""
               
               director = ""
               writer = ""
               actors = ""
               
               plot = ""
               language = ""
               country = ""
               
               awards = ""
               poster = ""

               BoxOffice = ""
               Website = "" 
               
               metascore = ""
               
               imdbRating = "" 
               imdbVotes = ""
               imdbID = ""
               
               tomatoMeter = ""
               tomatoImage = ""
               tomatoRating = ""
               tomatoReviews = ""
               tomatoFresh = ""
               tomatoRotten = ""
               tomatoUserMeter = ""
               tomatoUserRating = ""
               tomatoUserReviews = ""

               try:
                    #OMDB API    
                    #this url might be slow/unreliable
                    #omdb = openmovie database
                    response = "http://www.omdbapi.com/?t="+urlMovieName+"&plot=full&r=json&tomatoes=true"
                    #print(response)
                    responseText = urlopen(response).read().decode('utf-8')
                    ra = json.loads(responseText)#since output is in json 
                    '''
                    array
                    0- Title
                    1- Year
                    2- Rated e.g. R
                    3- Released 
                    4- Runtime 
                    5- Genre 
                    6- Director
                    7- Writer
                    8- Actors 
                    9- Plot
                    10- Language 
                    11- Country 
                    12- Awards 
                    13- Poster 
                    14- Metascore - metacritic.com score 
                    15- imdbRating
                    16- imdbVotes
                    17- imdbID
                    19- Type e.g.movie 
                    20- tomatoMeter(critic rating out of 100)
                    21- tomatoImage e.g. certified 
                    22- tomatoRating
                    23- tomatoReviews
                    24- tomatoFresh
                    25- tomatoRotten
                    26- tomatoUserMeter (user rating out of 100)
                    27- tomatoUserRating(/5)
                    28- tomatoUserReviews
                    29- DVD
                    30-BoxOffice (revenue)
                    31- Production 
                    32- Website
                    '''
                    #responseArray 
                    #ra = responseText.split(",")
                    
                    rated = ra["Rated"]
                    releaseDate = ra["Released"]
                    runtime = ra["Runtime"]
                    genre = ra["Genre"]
                    
                    director = ra["Director"]
                    writer = ra["Writer"]
                    actors = ra["Actors"]
                    
                    plot = ra["Plot"]
                    language = ra["Language"]
                    country = ra["Country"]
                    
                    awards = ra["Awards"]
                    #cant use this anymore because ia-media-imdb disabled hotlinking i.e  use of a linked object, often an image, on one site by a web page belonging to a second site
                    #poster = ra["Poster"]

                    BoxOffice = ra["BoxOffice"] 
                    Website = ra["Website"] 
                    
                    metascore = ra["Metascore"]
                    
                    imdbRating = ra["imdbRating"]
                    imdbVotes = ra["imdbVotes"]
                    imdbID = ra["imdbID"]
                    
                    tomatoMeter = ra["tomatoMeter"]
                    tomatoImage = ra["tomatoImage"]
                    tomatoRating = ra["tomatoRating"]
                    tomatoReviews = ra["tomatoReviews"]
                    tomatoFresh = ra["tomatoFresh"]
                    tomatoRotten = ra["tomatoRotten"]
                    tomatoUserMeter = ra["tomatoUserMeter"]
                    tomatoUserRating = ra["tomatoUserRating"]
                    tomatoUserReviews = ra["tomatoUserReviews"]

                               
                    '''     
                    insertQuery = "INSERT IGNORE INTO movieinfo (movieId, rated,releaseDate, runtime, genre, director,writer,actors,plot,language,country,awards,poster,boxOffice,Website) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s, %s,%s, %s, %s, %s, %s)"
                    x = conn.cursor()
                    x.execute(insertQuery, (movieId, rated, releaseDate, runtime,genre,director,writer,actors,plot,language,country,awards,poster,BoxOffice,Website))
                    conn.commit()  

                    insertQuery = "INSERT IGNORE INTO imdb (movieId, metaCriticScore,imdbRating,imdbVotes,imdbID) VALUES ( %s, %s, %s, %s, %s)"
                    x = conn.cursor()
                    x.execute(insertQuery, (movieId, metascore, imdbRating, imdbVotes, imdbID))
                    conn.commit()  

                    insertQuery = "INSERT IGNORE INTO tomato (movieId, tomatoMeter,tomatoImage, tomatoRating, tomatoReviews, tomatoFresh, tomatoRotten, tomatoUserMeter, tomatoUserRating, tomatoUserReviews) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
                    x = conn.cursor()
                    x.execute(insertQuery, (movieId, tomatoMeter,tomatoImage, tomatoRating, tomatoReviews, tomatoFresh, tomatoRotten, tomatoUserMeter, tomatoUserRating, tomatoUserReviews))
                    conn.commit() 
                    '''
                    #END OMDBAPI
               except:
                    #IF IT DOESNT WORK IN OMDB JUST USE YIFY-MOVIES
                    print("not found in omdb")

                    #genre 
                    genre = ""
                    for tag in soup.findAll('span', { "itemprop" : "genre" }):
                         genre += tag.text + " "
                  
                    runtime = ""
                    for tag in soup.findAll('span', { "itemprop" : "duration" }):
                         runtime += tag.text

                    language = ""
                    for tag in soup.findAll('span', { "itemprop" : "inLanguage" }):
                         language += tag.text + " "

                    releaseDate = ""
                    for tag in soup.findAll('span', { "itemprop" : "datePublished" }):
                         releaseDate += tag.text

                    imdbRating = ""
                    #(\s+) means 1 or more \t or \n etc (tab, newline...)
                    #format is <dt>IMDB Rating:</dt>\t\t\t\t\n\n\n\n<dd>86%</dd> if you print out the website in console 
                    imdbRegex = '<dt>IMDB Rating:</dt>(\s+)<dd>(.+?)</dd>'
                    pattern = re.compile(imdbRegex, re.DOTALL)
                    imdbText = re.findall(pattern, movieText)
                    for rating in imdbText:  
                         print("imdb "+rating[1])
                         imdbRating = rating[1]

                    tomatoMeter = ""
                    tomatoRegex = '<dt>TomatoMeter:</dt>(\s+)<dd>(.+?)</dd>'
                    pattern = re.compile(tomatoRegex, re.DOTALL)
                    tomatoText = re.findall(pattern, movieText)
                    for rating in tomatoText:  
                         print("tomatoMeter "+rating[1][:-1])
                         tomatoMeter = rating[1][:-1]

                    tomatoUserMeter = ""
                    tomatoRegex = '<dt>Audience Score:</dt>(\s+)<dd>(.+?)</dd>'
                    pattern = re.compile(tomatoRegex, re.DOTALL)
                    tomatoText = re.findall(pattern, movieText)
                    for rating in tomatoText:  
                         print("tomatoUserMeter "+rating[1][:-1])
                         tomatoUserMeter = rating[1][:-1]

                    #description
                    descriptionRegex = '<span itemprop="description">(.+?)</span>'
                    pattern = re.compile(descriptionRegex)
                    descriptionText = re.findall(pattern, movieText)
                    plot=""
                    for des in descriptionText:  
                         plot += des + " "

                    #director
                    directorRegex = '<span itemprop="director" itemscope itemtype="http://schema.org/Person"><strong>(.+?)</strong><span itemprop="name">(.+?)</span></span>'
                    pattern = re.compile(directorRegex)
                    directorText = re.findall(pattern, movieText)
                    director=""
                    for item in directorText:  
                         director += item[1] + " " 

                    #tag within tag
                    #<span itemprop = "author">  <span name = ...><span name = ...><span name = ...> </span>
                    '''
                    for outerTag in soup.findAll('span', { "itemprop" : "author" })
                         for tag in outerTag.findAll('strong'):
                              #print("writer "+tag.text)    
                              if 'Writers:' in tag.text:          
                                   for name in outerTag.findAll('span', { "itemprop" : "name" }):
                                        writer += name.text+","
                    '''


                    writer = ""                         
                    actors = ""
                    for outerTag in soup.findAll('span', { "itemprop" : "author" }):
                         for tag in outerTag.findAll('strong'):
                              print("author "+tag.text)
                              if 'Cast:' in tag.text:            
                                   for name in outerTag.findAll('span', { "itemprop" : "name" }):
                                        actors += name.text
                              elif 'Writers:' in tag.text:
                                   for name in outerTag.findAll('span', { "itemprop" : "name" }):
                                        writer += name.text
                    '''                    
                    poster = ""
                    for name in soup.findAll('img', { "itemprop" : "image" }):
                         poster = name['src']


                    '''  


                    '''   
                    #writer
                    writerRegex = '<span itemprop="author" itemscope itemtype="http://schema.org/Person"><strong>(.+?)</strong><span itemprop="name">(.+?)</span></span>'
                    pattern = re.compile(descriptionRegex)
                    text = re.findall(pattern, movieText)
                    writer=""
                    for item in text:  
                         writer += item[1] + " " 

                    
                    #description
                    descriptionRegex = '<span itemprop="description">(.+?)</span>'
                    pattern = re.compile(descriptionRegex)
                    description = re.findall(descriptionRegex, movieText)
                    descriptionText=""
                    for des in description:  
                         descriptionText += des + " "

                    #description
                    descriptionRegex = '<span itemprop="description">(.+?)</span>'
                    pattern = re.compile(descriptionRegex)
                    description = re.findall(descriptionRegex, movieText)
                    descriptionText=""
                    for des in description:  
                         descriptionText += des + " "  
                    '''   

               #poster
               poster = ""
               for name in soup.findAll('img', { "itemprop" : "image" }):
                    poster = name['src']

               #screenshots
               screenshots = ""
               for outerTag in soup.findAll('div', { "class" : "movie_left_column" }):
                    for link in outerTag.findAll('a'):
                         screenshots+=link['href'] + " "
               #insert into movieInfo
               insertQuery = "INSERT IGNORE INTO movieinfo (movieId, rated,releaseDate, runtime, genre, director,writer,actors,plot,language,country,awards,poster,boxOffice,Website, Screenshots) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s)"
               x = conn.cursor()
               x.execute(insertQuery, (movieId, rated, releaseDate, runtime,genre,director,writer,actors,plot,language,country,awards,poster,BoxOffice,Website, screenshots))
               conn.commit()  

               insertQuery = "INSERT IGNORE INTO imdb (movieId, metaCriticScore,imdbRating,imdbVotes,imdbID) VALUES ( %s, %s, %s, %s, %s)"
               x = conn.cursor()
               x.execute(insertQuery, (movieId, metascore, imdbRating, imdbVotes, imdbID))
               conn.commit()  

               insertQuery = "INSERT IGNORE INTO tomato (movieId, tomatoMeter,tomatoImage, tomatoRating, tomatoReviews, tomatoFresh, tomatoRotten, tomatoUserMeter, tomatoUserRating, tomatoUserReviews) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
               x = conn.cursor()
               x.execute(insertQuery, (movieId, tomatoMeter,tomatoImage, tomatoRating, tomatoReviews, tomatoFresh, tomatoRotten, tomatoUserMeter, tomatoUserRating, tomatoUserReviews))
               conn.commit()      



               subtitleURL = "http://www.opensubtitles.org/en/search2/sublanguageid-all/moviename-"
               subtitleURL = subtitleURL + urlMovieName

               subtitleText = urlopen(subtitleURL).read().decode('utf-8')
               
               soup = BeautifulSoup(subtitleText, "html.parser")
               
               #print(subtitleURL)
               
               #some urls (to the list of movies) automatically redirects to subtitles page so we need to handle that
               #subtitle page has a h1 tag with "name + subtitles"
               for tag in soup.findAll('h1'):
                    if fuzzy_match(tag.getText(), movie[1]+"subtitles"):
                         #we are already in subtitle page for our movie 
                         break
                    else:#we are in the page with the list of subtitle links for different movies so we need to find the link or our movie
                         for tag in soup.findAll('a', { "class" : "bnone" }, href = True):
                              #print(year)
                              latestYear = 2010
                              if fuzzy_match(tag.getText()[:-6], movie[1]): #:-6 to get rid of year eg (2015)
                                         #e.g. if theres Focus(2015) and Focus(2014) it will choose Focus(2015)
                                   try:
                                        tempyear = tag.getText()[-6:].replace("\t","").replace("(","").replace(")","")
                                        year = int(tempyear)
                                        if year > latestYear:
                                             latestYear = year
                                             #url of that goes to page showing all subtitles in different languages
                                             subtitleURL = "http://www.opensubtitles.org"+tag['href']
                                             subtitleText = urlopen(subtitleURL).read().decode('utf-8')
                                             #break
                                   except:
                                        print (tag.getText()[-6:].replace("\t","").replace("(","").replace(")",""))
                                        continue                                   
                           
                                   
    

               tomatoPartLink =  movie[1].replace(" ", "_").replace(":","")
               tomatoLink = "http://www.rottentomatoes.com/m/"+tomatoPartLink+"/"
               insertQuery = "INSERT IGNORE INTO links (movieId, youtubeLink,imdbLink,tmdbLink,tomatoLink, subtitleLink) VALUES (%s, %s, %s, %s,%s,%s)"
               x = conn.cursor()
               x.execute(insertQuery, (movieId, youtubeLink, imdbLink, tmdbLink, tomatoLink, subtitleURL))
               conn.commit() 
               #end insert links                         

               sleep(0.05)#sleep in between requests so no timeout 
     conn.close()
     #return movieId 
scrape("http://yify-movie.com/years/2015/")
  
for x in range(2, 14):     
     url = "http://yify-movie.com/years/2015/page/"+str(x)+"/"
     scrape(url)   
     
     
     
     
     
     
     


    
     
     
     
     
     
     
     
     
     
     
     
     
     
     
