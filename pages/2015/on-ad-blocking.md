# Ad Blocking, Ad Networks, & Your IP Address

First things first - ad blocking simply is the removal of advertisements from a web page. This is done via a few ways such as stopping web requests to advertising networks before they are made, stopping the execution of advertising networks code, or simply adding additional styles to a web page to "hide" an advertisement. 

Ad blocking has become popular as it has become more accessible to the average user. In the past, it would require editing a hosts file on a particular computer to reject content from known domains. Now, you install a browser extension on your browser or phone, and it does all the work for you.

Blocking ads is a big deal to publishers because it is their main revenue stream in most cases. Typically, publishers sign up with an advertising network which gives them a snippet of code to place in their own website. The advertising network commits to paying the publisher a few cents to several dollars per thousand users who view the advertisement. Sometimes the advertising network gives incentives for clicks on an ad, and will give a higher rate for clicks. 

Publishers, being the businesses that they are, usually talk to several ad networks, and test how much money they can make from each. Since each ad is tracked independently, they can make more money by placing more ads on each page. In simple terms, if each advertisement makes them $0.50 per thousand views, they can make $1.00 per thousand views if they place two ads on the site that get viewed or interacted with.

**Overall**: It's in the best interest of the publisher to make the most money from each customer.

-----

Advertising networks are the middlemen that make this entire transaction work. Advertising networks charge other businesses to place the ads on publishers’ sites / networks. Advertising networks promise the businesses that they will intelligently pick the best users to show their ads to. This includes the demographics of the publisher’s website, the demographics of the user based on location, and they also do something really neat, which is tracking each users viewing / clicking history. What this allows the advertising network to do is know when you have viewed a particular ad, and then show similar or dissimilar ads on future requests based what they think you like. These advertising networks actually make deals with other websites to place their code on them, so they can get a better idea of what you like, as well as do something fancy called "retargeting" which is when you view a product on a site, and then you start seeing ads for that product on other places on the web. For the record, retargeting is the gold standard for publishers, ad networks, and businesses purchasing ads because they can be traced back to product purchases, therefore allowing a premium ad price to be paid to all parties.

-----

Now that we understand a little more about how the business side of this works, let's take a look at what they can actually track. I'm going to take a fairly bare bones approach and just use my own ip address, and see what other deductions we can make from it. For the record, every single web request you make, you send your own ip address so that web servers know where to send you content, it’s a universal identifier which is core to the internet. Simply hiding advertisements doesn't prevent this, you must actually block the web request from happening.

My public IP is `98.168.143.37` which you can easily get from just googling “what’s my ip.”

[![](/images/rzm0vq0gs3yiwq.png)](/images/rzm0vq0gs3yiwq.png)

-----

Cool beans. So now I know that every web request I make on the internet, I send this ip `98.168.143.37` so that web servers know where to send content. One important thing to note is that most consumers probably have a “dynamic ip address” meaning that your internet service provider probably rotates this ip address ever 24-48 hours. Your internet service provider usually charges more money for static ip addresses which is where you keep the same ip forever.

Okay, so we’ve established I send the same string of numbers as my address. What could someone find out about you from that string of numbers? Lucky for me, I subscribe to a fun service called MaxMind which they claim to be 80-90+% accurate.

So I run a little curl request:
```
curl -u "{user_id}:{license_key}" \
       "https://geoip.maxmind.com/geoip/v2.1/insights/98.168.143.37?pretty"
```

And get back the following information:
```
{
   "city" : {
	  "confidence" : 38,
	  "geoname_id" : 4535389,
	  "names" : {
		 "en" : "Duncan",
		 "ru" : "Дункан"
	  }
   },
   "continent" : {
	  "code" : "NA",
	  "geoname_id" : 6255149,
	  "names" : {
		 "de" : "Nordamerika",
		 "en" : "North America",
		 "es" : "Norteamérica",
		 "fr" : "Amérique du Nord",
		 "ja" : "北アメリカ",
		 "pt-BR" : "América do Norte",
		 "ru" : "Северная Америка",
		 "zh-CN" : "北美洲"
	  }
   },
   "country" : {
	  "confidence" : 99,
	  "geoname_id" : 6252001,
	  "iso_code" : "US",
	  "names" : {
		 "de" : "USA",
		 "en" : "United States",
		 "es" : "Estados Unidos",
		 "fr" : "États-Unis",
		 "ja" : "アメリカ合衆国",
		 "pt-BR" : "Estados Unidos",
		 "ru" : "Сша",
		 "zh-CN" : "美国"
	  }
   },
   "location" : {
	  "accuracy_radius" : 8,
	  "average_income" : 27665,
	  "latitude" : 34.4853,
	  "longitude" : -97.8522,
	  "metro_code" : 650,
	  "population_density" : 653,
	  "time_zone" : "America/Chicago"
   },
   "maxmind" : {
	  "queries_remaining" : 9905
   },
   "postal" : {
	  "code" : "73012",
	  "confidence" : 34
   },
   "registered_country" : {
	  "geoname_id" : 6252001,
	  "iso_code" : "US",
	  "names" : {
		 "de" : "USA",
		 "en" : "United States",
		 "es" : "Estados Unidos",
		 "fr" : "États-Unis",
		 "ja" : "アメリカ合衆国",
		 "pt-BR" : "Estados Unidos",
		 "ru" : "Сша",
		 "zh-CN" : "美国"
	  }
   },
   "subdivisions" : [
	  {
		 "confidence" : 97,
		 "geoname_id" : 4544379,
		 "iso_code" : "OK",
		 "names" : {
			"en" : "Oklahoma",
			"es" : "Oklahoma",
			"ja" : "オクラホマ州",
			"ru" : "Оклахома"
		 }
	  }
   ],
   "traits" : {
	  "autonomous_system_number" : 22773,
	  "autonomous_system_organization" : "Cox Communications Inc.",
	  "domain" : "cox.net",
	  "ip_address" : "98.168.143.37",
	  "isp" : "Cox Communications",
	  "organization" : "Cox Communications",
	  "user_type" : "residential"
   }
}
```

So each and every web request I make to any website, can find out my city, state, zip code, internet service provider, time zone, average city income, average population, and if I’m residential. Technically I’m in Oklahoma City a hundred miles north of Duncan, but other IP services actually get it right.

[![](/images/i8x89cwcqtp79q.png)](/images/i8x89cwcqtp79q.png)

```
curl ipinfo.io
```

```
{
  "ip": "98.168.143.37",
  "hostname": "ip98-168-143-37.ok.ok.cox.net",
  "city": "Oklahoma City",
  "region": "Oklahoma",
  "country": "US",
  "loc": "35.4707,-97.5205",
  "org": "AS22773 Cox Communications Inc.",
  "postal": "73102",
  "phone": 405
}
```

Okay, so what else can you find out from my ip address if you know my location? Let’s try out a quick inclusive wolfram search.

[![](/images/yirzkri3vdlftq.jpg)](/images/yirzkri3vdlftq.jpg)

Each and every web request I make, you can potentially find out county information, race and demographics information, educational attainment, income statistics, economic statistics, crime rates, etc. Not only that, you can link my data with other ip addresses within a certain geo radius.

Wowee. So every request you make to an advertising network leaks all of that information. Think they aren’t doing this? Think again. Google Analytics allows demographic information for free! Imagine what advertising networks are collecting. Match up your ip information with your search history around the web over time, and now we’re talking about some serious data.

Ask yourself this as well, do you think that government subpoenas are or aren’t being made to advertising networks, who hold troves of data?

-----

We’ve touched on privacy, let’s touch on safety and speed.

-----

**Speed**

Look at the graphic below, and then go read this article from where I took the graphic from: [https://www.raymond.cc/blog/10-ad-blocking-extensions-tested-for-best-performance/view-all/]

[![](/images/w3gtswjmtrds6q.png)](/images/w3gtswjmtrds6q.png)

-----

**Safety** 

“Malvertising” is the use of online advertising to spread malware. This is typically where there is an exploit in your internet browser, and you download a virus by accident. 


Here are a few resources for you to peek at:
- [https://en.wikipedia.org/wiki/Malvertising]
- [https://en.wikipedia.org/wiki/Drive-by_download]


Here’s a recent article that came out on Sept 14th, 2015 titled “Large Malvertising Campaign Goes (Almost) Undetected” which lists the following sites sorted by traffic which were affected by malvertising.
- `ebay.co.uk` - 139M
- `drudgereport.com` - 61.30M
- `answers.com` - 53.8M
- `wowhead.com` - 27.8M
- `ehowespanol.com` - 20.30M
- `legacy.com` - 18.4M
- `newsnow.co.uk` - 15.50M
- `talktalk.co.uk` - 11.10M
- `manta.com` - 9.8M


Link:
- [https://blog.malwarebytes.org/malvertising-2/2015/09/large-malvertising-campaign-goes-almost-undetected/]


Also, MSN and Yahoo had the same thing happen:
- [https://blog.malwarebytes.org/malvertising-2/2015/08/angler-exploit-kit-strikes-on-msn-com-via-malvertising-campaign/]
- [https://blog.malwarebytes.org/malvertising-2/2015/08/large-malvertising-campaign-takes-on-yahoo/]

-----

**Manipulation - (Edited)**

People don't want to be manipulated into buying things they don't need. People are also concerned about their children being manipulated as well.

See hacker news:
- [https://news.ycombinator.com/item?id=10245613]

-----

Now you should be informed at the 3 (edit: 4) biggest arguments why you should be blocking ads. Let’s take a look at the arguments against blocking ads.

**Argument #1**

Blocking ads is violating an implied contract between the reader and the publisher. Because publishers give the content for free, you are obligated to load the ads and in essence pay for the article with your ad revenue.

**Argument #2**

Blocking ads is stealing. You wouldn’t go into a restaurant and not pay for food, why go to a website and not load the ads.

**Argument #3**

Blocking ads is taking away the revenue stream of independent publishers, and therefore publishers will go out of business.

**Argument #4**

Blocking ads hurts the children.

> “Every time you block an ad, what you're really blocking is food from entering a child's mouth.”

Via http://www.tomsguide.com/us/ad-blocking-is-stealing,news-20962.html

-----

**Personal opinion**

 Subject to change, likely to be hot headed for now:
- I will install ad blockers everywhere I can, and advocate everyone use one.
- Ad blockers on mobile is equally, if not more important than desktop ad blockers.
- There is no implied contract that you can dictate what I do and do not load. If I want to enable no script, or block cookies, or use a vpn with a rotating ip address, I will. All these things will change your ad revenue.
- Ad networks are sleazy, creepy, and I don’t want to do business with them.
- Malvertising and drive by downloads are real fucking problems. They are exploiting online advertising.
- Speed boost is a nice to have, but not a reason alone to block ads.
- If you don’t want to provide content without me looking at ads, then don’t show my content when I use an ad blocker. The work has already been done for you here: [https://github.com/sitexw/FuckAdBlock]
- You cannot be against government / big business bulk collection of metadata, and not be pro ad blocker. Privacy is important. And leaking tons of identifying info about yourself all over the internet is not good.
