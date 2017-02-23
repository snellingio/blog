# Hacking Oklahoma State University’s Student ID

## Introduction

READ THIS AFTER - a full follow up here: http://snelling.io/following-up-hacking-oklahoma-state-universitys-student-id

In 2013 I took an Information Security class at Oklahoma State University. As a final project, we were broken into teams to find a security hole, and have a plan to theoretically exploit it.

I led this project, and in early 2014, gave a presentation to key faculty and IT security on campus. As I understand it, the final solution was to take down the website (https://app.it.okstate.edu/idcard/), and not worry about the rest. Fair enough.

EDIT: Many have asked, here is a quote from http://it.okstate.edu/policies/pol_osuid.php

>Disclaimers - The Oklahoma State University ID Services office is not liable for financial loss or criminal repercussions associated with lost, stolen, damaged, or fraudulently used OSU ID Cards. Personal information is kept secure and confidential at ID Services. Outside parties are not privileged to personal or account information unless express consent is granted or the University is required to comply with legal or government agencies.

Here are the contents of my final report.

---------------------------------------

## Magnetic Stripe Primer 
Section via Wikipedia http://en.wikipedia.org/wiki/Magnetic_stripe_card

A magnetic stripe card is a type of card capable of storing data by modifying the magnetism of tiny iron-based magnetic particles on a band of magnetic material on the card. The magnetic stripe, sometimes called swipe card or magstripe, is read by swiping past a magnetic reading head. 

Magstripes come in two main varieties: high-coercivity (HiCo) and low-coercivity (LoCo). High-coercivity magstripes require higher amount of magnetic energy to encode, and therefore are harder to erase. HiCo stripes are appropriate for cards that are frequently used, such as a credit card. Low-coercivity magstripes require a lower amount of magnetic energy to record, and hence the card writers are much cheaper than machines which are capable of recording high-coercivity magstripes. However, LoCo cards are much easier to erase and have a shorter lifespan. 

A card reader can read either type of magstripe, and a high-coercivity card writer may write both high and low-coercivity cards (most have two settings, but writing a LoCo card in HiCo may sometimes work), while a low-coercivity card writer may write only low-coercivity cards. In practical terms, usually low coercivity magnetic stripes are a light brown color, and high coercivity stripes are nearly black.

There are up to three tracks on magnetic cards known as tracks 1, 2, and 3. (Sam’s Note: Track 3 is rarely ever used in the United States)

Track 1, Format B:
- Start sentinel — one character (generally '%')
- Format code="B" — one character (alpha only)
- Primary account number (PAN) — up to 19 characters. Usually, but not always, matches the credit card number printed on the front of the card.
- Field Separator — one character (generally '^')
- Name — two to 26 characters
- Field Separator — one character (generally '^')
- Expiration date — four characters in the form YYMM.
- Service code — three characters
- Discretionary data — may include Pin Verification Key Indicator (PVKI, 1 character), PIN Verification Value (PVV, 4 characters), Card Verification Value or Card Verification Code (CVV or CVC, 3 characters)
- End sentinel — one character (generally '?')
- Longitudinal redundancy check (LRC) — it is one character and a validity character calculated from other data on the track. 

Track 2:
- Start sentinel — one character (generally ';')
- Primary account number (PAN) — up to 19 characters. Usually, but not always, matches the credit card number printed on the front of the card.
- Separator — one char (generally '=')
- Expiration date — four characters in the form YYMM.
- Service code — three digits. The first digit specifies the interchange rules, the second specifies authorization processing and the third specifies the range of services
- Discretionary data — as in track one
- End sentinel — one character (generally '?')
- Longitudinal redundancy check (LRC) — it is one character and a validity character calculated from other data on the track. Most reader devices do not return this value when the card is swiped to the presentation layer, and use it only to verify the input internally to the reader. 

Service code values common in financial cards:

First digit

	1: International interchange OK

	2: International interchange, use IC (chip) where feasible

	5: National interchange only except under bilateral agreement

	6: National interchange only except under bilateral agreement, use IC (chip) where feasible

	7: No interchange except under bilateral agreement (closed loop)

	9: Test

Second digit

	0: Normal

	2: Contact issuer via online means

	4: Contact issuer via online means except under bilateral agreement

Third digit

	0: No restrictions, PIN required

	1: No restrictions

	2: Goods and services only (no cash)

	3: ATM only, PIN required

	4: Cash only

	5: Goods and services only (no cash), PIN required

	6: No restrictions, use PIN where feasible

	7: Goods and services only (no cash), use PIN where feasible

---------------------------------------

## Oklahoma State ID Card
The OSU ID Card is the official identification card for Oklahoma State University. Your ID Card can be used for: 
- Photo identification
- Access to certain buildings and facilities on campus
- Charges to your OSU Bursar account
- Access to a variety of campus events and services
Via http://it.okstate.edu/services/id/ 

[![](/images/ytayjecoyy9hq.jpg)](/images/ytayjecoyy9hq.jpg)

(Photo of an Oklahoma State ID Card -- Note bottom right corner: “Card: 6038 3800 0534 5615”)

---------------------------------------

## Hypothesis
- Every Oklahoma State student / faculty identification card (“ID Card”) is inherently insecure. 
- Every ID Card is unique only by the card number -- which is 16 digits long. 
- By exploiting the ID Card, one could cause massive theft, damage, and trespass into secure areas.
- One would not get caught, and no one would notice until it is too late. 

---------------------------------------

## Research
Every ID Card has a card number starting with 6038 3800 that will be referred to as the “Base Number”. The only exception to the Base Number is the ID Card that are not issued by Oklahoma State -- And are instead issued by Stillwater National Bank and act as a student’s actual bank card as well.

Out of the next eight digits, the first two numbers will be referred to as the “Head Number.” Out of the ID Cards that have been analyzed (>100), there have only been three Head Numbers: 05, 06, 11. 

The last six digits will be referred to as the “Tail Number.” The tail number can contain any digit 0-9, 10 combinations per number. Doing the math 10^6 = 1 million possible combinations. 

With 3 possible Head Numbers * 1 million possible Tail Numbers = roughly 3 million possible ID Card numbers.

Oklahoma State has printed on the back of every ID Card a link to the Oklahoma State web service to see if an ID is valid: https://app.it.okstate.edu/idcard/

[![](/images/wswnepovrzifq.png)](/images/wswnepovrzifq.png)
This web service allows anyone to enter a 16 digit ID Card number, and see whether it is valid or invalid.

A valid card number will look similar to this:
[![](/images/vbom0ved1dlcza.png)](/images/vbom0ved1dlcza.png)

Whereas an invalid card number will look similar to this:
[![](/images/igzsxqsfdcgorw.png)](/images/igzsxqsfdcgorw.png)

Querying to the web service returns the following information:
- Card Number: The ID Card number you just queried
- ID Card Status: “Valid” or “Invalid ID Number”
- Employment Status: The current employment status (by the university) of the card holder
- Student Status: The current enrollment status of the of the card holder
- Other: Whether or not there is anything special about the card -- Bank card, etc.

The web service has a disclaimer at the top - “Use of this service is logged and tracked.” The assumption would be that Oklahoma State is logging IP addresses of every query to the service. There are two problems with this approach, with no solution:
- IP banning from a web service is only so effective as it is extremely easy to obtain an IP proxy list. An up-to-date list of over 300,000 proxies is $9/month. Via http://ninjaproxies.com/plans 
- Good luck to Oklahoma State prosecuting as In 2011, Judge Harold Baker ruled that an IP address does not equal a person. Via http://torrentfreak.com/ip-address-not-a-person-bittorrent-case-judge-says-110503/

By purchasing a USB magnetic stripe reader for roughly $25 you are able to decode an ID Card. Via http://www.rakuten.com/prod/usb-3-track-magnetic-credit-card-reader/240738725.html

This is what a ID Card looks like decoded:

`
%B6038380006514029^SNELLING/SAMUEL R     	^491212000000000   	000   ?;6038380006514029=49121200000000000000?
`

By referencing the encoding structure, the ID Card follows the structure:
Track one:
- %B
- ID CARD NUMBER
- ^
- LAST/FIRST NAME
- ^
- EXPIRATION DATE: 49/12
- SERVICE CODE: 120
- DISCRETIONARY DATA: 000000000   	000   
- ?
Track 2:
- ;
- ID CARD NUMBER
- =
- EXPIRATION DATE: 49/12
- SERVICE CODE: 120
- DISCRETIONARY DATA: 0000000000000
- ?

There are several issues with the current approach, but the most egregious two are:
- Everyone’s expiration data are the exact same - 49/12
- All discretionary data is blank 

---------------------------------------

## What we know
What we know up to this point is the following:
- Oklahoma State issues ID Cards to all students and faculty
- All ID Cards (with one exception) have a Base Number of 6038 3800
- All ID Cards have a Head Number of either: 05, 06, 11
- There are roughly 1 million Tail Numbers per Head Number combinations
- Oklahoma State has a web service that allows anyone over the internet to check the validity of an ID Card number
- This web service logs and tracks all queries, probably by IP
- All ID Cards have the exact same expiration date: 49/12
- All ID Cards have blank (0’s) discretionary data

---------------------------------------

## Unitech MSRC206 & SSI Technologies
Note: due to shipping delays of our MSRC206 (magnetic stripe card reader / writer), Sam had to travel to Oklahoma City to meet with SSI Technologies. SSI Technologies uses the MSRC206 exclusively for all testing, and encoded all of cards for us. Via http://www.ssicards.com/

The MSRC206 is made by Unitech, and is a commercial grade magstripe reader / writer. What makes the MSRC206 a good choice for an encoder is that it supports both HiCo and LoCo cards, as well as has a strong enough encoder to overwrite existing HiCo cards. The MSRC206 retails for between $300-500 USD. Cheaper alternatives can be bought for under $200. Via http://www.newegg.com/Product/Product.aspx?Item=9SIA1EF0CD0616

Using the MSRC206 is extremely simple as explained by this 2:00 Youtube video. Via http://www.youtube.com/watch?v=k2lZrkc0cwI

How to copy a magnetic stripe:
You need a magnetic stripe card with data on it, and a blank magnetic stripe card
- Plug in MSRC206 to wall and into computer -- Allow drivers to install
- Install software included with MSRC206
- Wait for MSRC206 to connect to MSRC206 software
- Hit the “Read” button on right hand panel of software
- Swipe card with encoded data on it through
- Hit the “Write” button on right hand panel of software
- Swipe blank card though 
After arriving at SSI technologies and getting a tour through the facilities, our team requested two different copies of Sam’s Oklahoma State University ID Card.


Original data:

`
%B6038380006514029^SNELLING/SAMUEL R     	^491212000000000   	000   ?;6038380006514029=49121200000000000000?
`

Copy onto blank card:

`
%B6038380006514029^SNELLING/SAMUEL R     	^491212000000000   	000   ?;6038380006514029=49121200000000000000?
`

Copy with changed name onto blank card:

`
%B6038380006514029^PETE/PISTOL          	^491212000000000   	000	?;6038380006514029=49121200000000000000?
`

Side by side:

`
%B6038380006514029^SNELLING/SAMUEL R     	^491212000000000   	000   ?;6038380006514029=49121200000000000000?
`

`
%B6038380006514029^PETE/PISTOL          	^491212000000000   	000	?;6038380006514029=49121200000000000000?
`

There are two important differences to note:
- The name has been changed, but the card number has remained the same
- The spacing is *slightly* off on the pistol pete card due to an encoding error 

---------------------------------------

[![](/images/m40zhc7baznug.jpg)](/images/m40zhc7baznug.jpg)

Top left - Copy of ID Card with “Pistol Pete” encoded; Top right - Copy of ID Card; Bottom left - ID Card; Bottom right - Copy of ID Card;

[![](/images/bxkcjbxbnsoakg.jpg)](/images/bxkcjbxbnsoakg.jpg)

Top left - Copy of ID Card with “Pistol Pete” encoded; Top right - Copy of ID Card; Bottom left - ID Card; Bottom right - Copy of ID Card;

Note -- These are the cards used in when testing the hypothesis.

---------------------------------------

## Testing the hypothesis
Our team set out to use the blank cards in various settings.

First, our team tried to check out a Surface Pro from the library using the original ID Card. Since Sam had gotten a new ID Card only one day ago, he was not in the system. The Library technician asked if it was a “new ID Card” and that “the Library usually takes a few days to sync with new ID Cards.” What this tells us is that the Library does not check each and every transaction with the central ID Card server to make sure it is valid (since Sam’s original ID Card was valid). The assumption would be that the library downloads data dumps once every few days, and stores them on the computer to run a local check to allow students to check out items.

Next, our team decided to use the “Pistol Pete” ID Card at both the Library Cafe and the Union Express on campus. Watch via http://youtu.be/Bw2Ugezb7Fs

Several things are interesting about this test:
1. Staff of the university accepted a blank ID Card
2. Even while the ID Card had the name “PETE/PISTOL” encoded on it, when used the transaction still appears under Sam’s name. 
This tells us that the point of sales systems check with the server each transaction to make sure the card is valid, however it does not check the name of the card to make sure it is the same on both server and card.

---------------------------------------

## What we know (again)
What we know up to this point is the following:
- Oklahoma State issues ID Cards to all students and faculty
- All ID Cards (with one exception) have a Base Number of 6038 3800
- All ID Cards have a Head Number of either: 05, 06, 11
- There are roughly 1 million Tail Numbers per Head Number combinations
- Oklahoma State has a web service that allows anyone over the internet to check the validity of an ID Card number
- This web service logs and tracks all queries, probably by IP
- All ID Cards have the exact same expiration date: 49/12
- All ID Cards have blank (0’s) discretionary data
- The Unitech MSRC206 can read, edit, encode, and re-encode magnetic stripes
- The Library does not verify each ID Card transaction with a central server
- Staff of the university accepted a blank ID Card
- Point of sales systems verify each ID Card transaction with a central server
- Point of sales systems do not validate the name on an ID Card

---------------------------------------

## Theoretically exploiting the system
Now with everything that we know, it is possible to start harvesting ID Card numbers from https://app.it.okstate.edu/idcard/ using a basic Node.js web scraper. I have written 15 lines of code to take advantage of this web service. 

```
var cheerio = require('cheerio'), 
request = require('request'), 
fs = require('fs'), 
headnumber = '06';

for (var i=1; i <= 100; i += 1){
	var tailnumber = '';
	while (tailnumber.length < 6) 
	tailnumber = tailnumber + '' + [0,1,2,3,4,5,6,7,8,9][Math.floor(Math.random()*9)];
	request.post('https://app.it.okstate.edu/idcard/index.php/module/Default/action/IDCardEntry', {form:{card_id:'60383800'+headnumber+tailnumber}}, function (error, response, html) {
		if (!error && response.statusCode == 200) {
	 		var $ = ch3eerio.load(html);
	 		$('td.formText').each(function() {
				var text = $(this).next().text();
				fs.appendFile('osu_ids.txt', text+';', function(err){});
			});
			fs.appendFile('osu_ids.txt', '\r\n', function(err){});
	 	}
	}); 
}

```

This code will essentially generate random Tail Numbers with a specified Head Number and log the result. After testing the web service, we have determined that it will handle roughly 3-5 requests per second (this is pretty terrible, but understandable for a web service that is not supposed to be used). So if you assume roughly 1 Million Tail numbers per Head Number at 5 / sec, you could theoretically brute force every single valid ID Card in 2 days. By optimizing this algorithm, it is reasonable to expect that you can find thousands of valid ID Cards in less than an hour ON ONE MACHINE! Think if we spun up an entire cluster of systems on a cloud hosting service.

You could then either
1. Print your own ID Cards using other card numbers
2. Re-encode your own ID Card with another card number by overwriting it with the MSCR206 
As we have proved: 
- Current systems do not check names on ID Cards
- All ID Cards have the same expiration dates and discretionary data
- Only the ID Card number itself is unique to the card

---------------------------------------

## The threat is bigger than you think
Your ID Card gets you access to certain buildings and facilities on campus, allows you to charge items to your OSU Bursar account, and allows you access to a variety of campus events and services.

Another thought experiment -- Has Oklahoma State made a giant mistake by letting students use ID Cards as football tickets?

Every student organization that is currently keeping attendance through the Spears School of Business “checkout” magnetic stripe readers is currently sitting on a treasure trove of ID Card numbers. How is this data being handled? (I’m looking at you ISAC)

So is the threat just that someone can steal some football tickets? What about charging hundreds of dollars worth of books to someone elses bursar? What about stealing thousands of dollars of equipment using others information from the Library or another building? What if someone could get access to the HBRC? What if I get the ID Card number to a faculty member? The possibilities here are limitless as we rely on this technology more and more.

---------------------------------------

## Fixing the problem -- The right way
To be honest, you won’t like this answer.

Here are the steps in order of importance:
- Take down https://app.it.okstate.edu/idcard/ TODAY!
- Go back to the drawing board on ID Cards
- Reissue everyone a new ID Card
- Audit all systems that touch ID Cards
- Get rid of any system that is not checking each transaction
- Please, for the love of god, do not make the transaction endpoint insecure
- Add a second form of verification 

Detailed responses:
- Take down https://app.it.okstate.edu/idcard/ TODAY! If you do not do this -- Everything is at risk. Seriously. As it currently sits, it is waiting to be scraped. It could theoretically be done by the time you are finished reading this document.
- Go back to the drawing board on ID Cards. How we are currently doing it is WRONG. Everyone needs their own expiration date. Discretionary data should include a “check digit.” Here are two links that need to be read over before even talking. See links below:
	- Luhn’s Algorithm: http://en.wikipedia.org/wiki/Luhn_algorithm
	- Magnetic Stripe Examples: http://www.gae.ucm.es/~padilla/extrawork/magexam1.html
- Reissue everyone a new ID Card. This needs to happen. If you only take down the website -- and do not reissue everyone a new ID Card -- All someone has to do is read the last 6-8 digits off your card, and then go home and encode it. If you do not reissue cards, everyone will still be at risk.
- Audit all systems that touch ID Cards. The Library’s system, All door code readers, All POS systems,
-All data needs to be verified on each swipe. Including the name. Also, no device should be able to store a dump of ID Card numbers / data on it.
- Get rid of any system that is not checking each transaction. This goes back to no device should be able to store a dump of ID Card numbers / data on it. If someone is able to get their hands on a dump of that data -- Everything is compromised. Even if you reissue everyone a new ID Card, and add a check digit… a copy of a card will be a copy of a card.
- Please, for the love of god, do not make the transaction endpoint insecure. So now that you’ve added check digits, and made all the systems check with the server to make sure they are all allowed, you will have systems like the Library that you will have to rewrite code for. MAKE SURE THE ENDPOINT IS SECURE. If you aren’t encrypting the data before it goes over the wire, and also using SSL, the system is again broken. Make sure you secure the endpoint properly.
- Lastly, add a second form of verification. Make people use a PIN number when making transactions. That’s a pretty good way to combat this from all sides. Yes, someone can still find out your pin and clone your ID -- But you’ve made it 1000x stronger than what it was. Another idea is to add a barcode to each ID Card that needs to be scanned in as well (think of it as a 2 step verification). 

-------------------------

## Following up

A full follow up here: http://snelling.io/following-up-hacking-oklahoma-state-universitys-student-id