# New Office

In 2012 I lived in a two bedroom, 500sqft apartment with one of my best friends. In 2013, I moved in with my (then future) wife. In late 2014, we moved to Edmond Oklahoma where we rented a house, and started a software development business together. Fast forward to 2016, where we are now living in our new house. 

[![](images/l7oiai8ws657q.jpg)](images/l7oiai8ws657q.jpg)

One of the biggest perks about building a house (and working from home), is figuring out exactly what you want to do with your working space. It’s been a long time coming, but I finally have an office to be proud of.

[![](images/kh6nmtouloysa.jpg)](images/kh6nmtouloysa.jpg)

# The Homelab

(Edit: Here is the most up to date photo)
[![](images/uoh3ivsg4s7w.jpg)](images/uoh3ivsg4s7w.jpg)

[![](images/lksehkh6fjqg.jpg)](images/lksehkh6fjqg.jpg)

[![](images/gyteg2bewepfq.jpg)](images/gyteg2bewepfq.jpg)

## Rack & shelf
- [Skeletek 12U Rack](http://www.dantraknet.com/item/120)
- [2U Shelf](https://www.amazon.com/gp/product/B008X3JHJQ/)

I originally found the Skeletek rack from someone who posted a recommendation on reddit for a larger version. I knew I wanted a small, sturdy, two post rack. Skeletek 12U fit the bill, apparently holds like a thousand pounds, and one of their selling points is they sell a kit that turns it into a 24U rack. I bought the 2U shelf because it was reasonably short, and had a weight capacity of 50lbs, which was plenty for my cat to jump up and down on it. I intentionally went with a two post rack as I didn’t think a four post footprint would work for my needs, what this means is that I have extra constraints when picking out server chassis’, and while I could technically center mount servers, I’m going to stick with things that work with the rack ears.

## Cabling
- [(2) CyberPower PDU Surge Protectors](https://www.amazon.com/CyberPower-CPS-1215RMS-Rackmount-Power-Surge/dp/B00077INZU/)
- [(2) 16 Port Keystone Passthrough Panels](https://www.computercablestore.com/1u-blank-patch-panel-16-port)
- [Cyberpower 1500VA 900W UPS](https://www.amazon.com/CyberPower-CP1500PFCLCD-Sinewave-Compatible-Mini-Tower/dp/B00429N19W/)

When I originally conceived the new office, I wanted every single room to have CAT6 cabling. All the cables were then pulled into the office and terminated for me. After lots and lots of searching, I came across keystone jacks, which come in punch down or female to female RJ-45. The pass through patch panel really cleans up the cabling for me, and I’ve been really happy with it. Only thing to note about the power strips is that they have plugs on front and back, which allows me to have easy access to power from either side. UPS is behind the rack.

## Networking
- [Ubiquiti Unifi Security Gateway Pro](https://www.ubnt.com/unifi-routing/unifi-security-gateway-pro-4/)
- [Ubiquiti Unifi 24 Port 500W POE Switch](https://www.ubnt.com/unifi-switching/unifi-switch/)
- [Ubiquiti Unifi 24 Port Switch (non POE)](https://www.ubnt.com/unifi-switching/unifi-switch/)
- [Ubiquiti Unifi AP AC Pro](https://www.ubnt.com/unifi/unifi-ap-ac-pro/)
- [Surfboard SB6190 Modem](https://www.amazon.com/gp/product/B016PE1X5K/)

I went all Ubiquiti. The Security Gateway (the router) running off of the [Unifi software](https://www.ubnt.com/enterprise/software/) (Vyatta fork) is limiting as opposed to something like pfSense or a Sophos box as it doesn’t really have any “security” features except port control, however there is great value in having a [fully connected software suite](https://www.ubnt.com/enterprise/software/). When I originally ordered the switch, I actually ordered a 250W 24 port switch, but it came stuck in a reboot loop and I had to RMA it. Instead of waiting a long lead time for backordered 250W system, I spent the extra money to bump it to a 500W system. Both the Security Gateway and the Switch had really whiney fans (apparently this has been fixed with the new revisions), so I purchased some tiny Noctua’s that keep it whisper quiet and the temps low. The AP has been rock solid, and currently hangs in the kitchen powered from POE. After a month, I added the second 24 port non POE switch, for extra networking for IPMI, and redundant links to the super micro servers.

## Servers
- [Custom Short Depth Supermicro Server](https://www.ubnt.com/unifi-switching/unifi-switch/)
- [(2) Refurbished Short Depth Supermicro Servers](http://stores.ebay.com/MrRackables)

I started by purchasing a Supermicro barebones kit off of Amazon. I added a [Xeon E3-1275 v5](http://www.cpubenchmark.net/cpu.php?cpu=Intel+Xeon+E3-1275+v5+%40+3.60GHz), bought 64GB of ram, and 250GB Evo 850 for it. I threw in [Proxmox](https://www.proxmox.com/en/) and had a little virtualization lab. I eventually ran across two short depth servers on Ebay, with the original [Xeon E3-1270](http://www.cpubenchmark.net/cpu.php?cpu=Intel+Xeon+E3-1270+%40+3.40GHz) with 8GB of ram, and pulled the trigger. I replaced the blower fans in both refurb units to something a little quieter. The refurb units both run Proxmox, and stay off until I have a workload for them. The custom is running 24x7. All 3 servers are set to run backups to my Synology’s.

## Storage
- [Synology DS716+](https://www.synology.com/en-us/products/DS716+II), [Synology DX213](https://www.synology.com/en-us/products/DX213) & [(4) 2TB HGST Ultrastars](http://www.newegg.com/Product/Product.aspx?Item=9SIA5AD3H22332)

I originally purchased a 716+ when the plus line was recommended to me (Note, the 716+ has been replaced with the 716+II with a slightly different processor). Formatted it with [Btrfs](https://en.wikipedia.org/wiki/Btrfs) as the 716+ was one of the first to support it. I purchased an 8GB ram module, and voided the warranty immediately by bumping up from the original 2GB. To be honest, I hardly ever use more than 2GB of ram and would’ve been just fine with the originally installed amount. After getting my photos, movies, music collections all running through the 716+, I started running snapshots from all my servers and set it to as the time machine target from the OS X server. I went on [Amazon Business](https://www.amazon.com/b?node=11261610011) (different from the normal consumer Amazon), and they had the 213 for $60 off. I bought all 4 of my 2TB HGST Ultrastars from two different batches at $50/ea, which seemed like an incredible deal at the time.

## Miscellaneous Server Equipment
- [Raspberry Pi 2](https://www.amazon.com/Raspberry-Pi-Model-Project-Board/dp/B00T2U7R7I/), [Raspberry Pi 3](https://www.amazon.com/Raspberry-Pi-RASP-PI-3-Model-Motherboard/dp/B01CD5VC92/) & [POE splitters](https://www.amazon.com/microUSB-Splitter-Ethernet-Raspberry-WT-AF-5v10w/dp/B019BLMWWW/)
- [(2) Unifi G3 Dome Cameras](https://www.ubnt.com/unifi-video/unifi-video-camera-g3-dome/)

I’ve been tinkering around with Raspberry Pi’s for a while now. The Raspberry Pi 2 runs as a [Pi Hole](https://pi-hole.net/), whereas the Pi 3 runs as a little testbed unit. The real unique thing about my setup is the POE splitters. If you look on Amazon there are tons of options in the $5-10 range. I no longer have to run extra power cables, just plug the Pi into a POE splitter and now it’s powered off the switch. I recently added two Unifi dome cameras that both run via POE in the front and back of the house. They run off the [Unifi Video controller](http://community.ubnt.com/t5/UniFi-Video/ct-p/airVision) that runs on the Supermicro, which records video files to the Synology. I plan on adding several [UVC-Micro’s](https://www.ubnt.com/unifi-video/unifi-video-camera-micro/) when they are [updated later in 2016](https://community.ubnt.com/t5/UniFi-Video/Has-the-UVC-Micro-been-discontinued/m-p/1558202#M56523).

# The Battlestation

[![](images/rrjjltk8fyguia.jpg)](images/rrjjltk8fyguia.jpg)

[![](images/yiar2jjp1mcig.jpg)](images/yiar2jjp1mcig.jpg)

## Desks
- [8’ Gladiator Adjustable Height Workbench](http://www.gladiatorgarageworks.com/products-1/workbenches-2/workbenches-3/-[GAWB08BAZW]-1700181/GAWB08BAZW/)
- [(2) 6’ Gladiator Adjustable Height Workbenches](http://www.gladiatorgarageworks.com/products-1/workbenches-2/workbenches-3/-[GAWB06BAZW]-1700177/GAWB06BAZW/)

Office furniture is expensive. I’ve wanted a standing desk for about 3 years now, however I’ve always been put off by reviews talking about “wobbling.” I almost bought a pricey Steelcase standing desk, before deciding to look up wooden tops (I thought I might be interested in building a desk from scratch at one point). After looking at custom tops, I ran across cheaper workbench tops, which led me looking at workbenches, which led me to some of the nicest workbenches I’ve ever seen, from Gladiator Garage Works. My dad had a Gladiator set in his garage a long time ago, so I already had some bias going into looking at the workbenches. They claim to hold 3000lbs each, and don’t move or wobble at all.

## Standing / Sitting
- [(3) Imprint Commercial Anti-Fatigue Mats](http://shop.imprintmats.com/collections/cumuluspro/products/commercial-grade-black?variant=943588251)
- [(3) Metal Barstools](https://www.amazon.com/gp/product/B00T0EG2OA/)

I ended up getting at Imprint mats after several friends recommended them. They had a really good deal (35-40% off), and I ended up purchasing 3 of them. Originally I thought I might buy a drafting chair, but they are pretty expensive ($300-1XXX), and I was concerned about where to put them. Barstools ended up being the perfect balance of height, affordability, matching (looking good), and storability.

## Computers
Main machine, OS X:
- [Intel i7 4771 Processor](http://www.cpubenchmark.net/cpu.php?cpu=Intel+Core+i7-4771+%40+3.50GHz&id=2027)
- [32GB DDR3 Ram](http://www.newegg.com/Product/Product.aspx?Item=N82E16820148540)
- [(2) 250GB Samsung 840 Evo’s](http://www.newegg.com/Product/Product.aspx?Item=N82E16820147248)
- [GTX 960 4GB Graphics Card](https://www.amazon.com/gp/product/B00UOYQ5LA/)
- [Fractal Design Case](http://www.newegg.com/Product/Product.aspx?Item=N82E16811352011)

Built this computer as a high end machine in college with one of my best friends as a database server. Now serves as my daily machine. I’ve changed operating systems 4-5 times as most of my code / development setup is stored on a NAS and server. Currently it’s hackintosh’ed, but I’ve had Ubuntu and Windows Insider Preview on it as well. No real strong opinions on why this is better / worse than any other machine, it just works for me. The GTX 960 was the cheapest card with 4 monitor inputs (3 display ports) when I bought it. My current setup has two 4k displays and one 16:10 display all running through the 960, and the other 16:10 display running on integrated graphics, all via display port with 60Hz refresh rates. I don’t game much, so I don’t run into almost any issues.

Secondary machine, 2009 Mac Pro, OS X Server:
- [3.33 GHz 6-Core Intel Xeon](http://www.everymac.com/systems/apple/mac_pro/specs/mac-pro-six-core-3.33-mid-2010-westmere-specs.html)
- 16GB Ram
- [240GB OWC SSD](https://eshop.macsales.com/shop/SSD/OWC/lineup)

Purchased in 2015 to replace my main machine. It’s technically a 2009 Mac Pro that was firmware upgraded so they could throw in the [six core Xeon W3680 (Westmere) processor](http://www.cpubenchmark.net/cpu.php?cpu=Intel+Xeon+W3680+%40+3.33GHz). Ultimately ended up liking my other machine more, even though the 6 core Xeon benchmarks better than the 4771. Case is pretty damaged. I keep this around as an OS X server & testing device. I use it daily with VNC server. The weakest potion of this machine is the graphics, as the GT120 is really really old and weak. Newer “flashed” Mac video cards cost an arm and a leg for what you get, so I just bought a [little headless display adapter](https://eshop.macsales.com/item/NewerTech/ADP4KHEAD/), and use it to offload work to.

Laptops:
- [Chromebook Pixel (2015)](https://store.google.com/product/chromebook_pixel_2015)
- [Dell Chromebook 11 (2014)](http://www.dell.com/us/business/p/chromebook-11/pd)
- Macbook Pro 15" (2015 Refurbished)
- Macbook Pro 13" (2013)
- Lenovo Thinkpad T410 (2010) - Ubuntu 16.04

Chromebook Pixel & Macbook Pro 13" are both used by my wife, Rachel. I occasionally share the Macbook Pro depending on working environment. Thinkpad was my original laptop, and serves primarily as a test device. Chromebook 11 serves as my travel device. As an aside, we love ChromeOS in this household. We use Google Apps exclusively for our business, and ChromeOS requires literally 0 maintenance. Love it. You might notice at this point there is nothing running Windows. That's not on purpose. We do have a couple of older Windows machines that we pull out 3-4 times a year for taxes.

## Monitors
- [(2) 24” 1920x1200 Dell Ultrasharp Monitors](https://www.amazon.com/gp/product/B005JN9310/)
- [(2) 24” 3840x2160 Dell Ultrasharp Monitors](https://www.amazon.com/gp/product/B00PC9HFNY/)
- [(2) Dual Monitor Stands](https://www.amazon.com/gp/product/B0052AWGLE/)

All four displays are connected via display port to the GTX 960 / integrated graphics. I originally started out with 1 of the 1920x1200 displays and loved it so much I bought another one. The second one’s screen temperature didn’t quite match the first, and had to go through a lot of calibration. Upgraded to the 4k displays in early 2015 on an Amazon sale. Keeping the old displays paid off big time when I moved to my new office.

## Accessories
- [Code Tenkeyless Keyboard, Cherry MX Clears, O-Rings](https://codekeyboards.com/)
- [Headphone Stand and USB Hub](https://www.amazon.com/gp/product/B019PI9QD4/)
- [Wren (Bamboo) Bluetooth Speaker](http://www.crutchfield.com/p_846V5BTB/Wren-V5BT-Bamboo.html)
- Bose QuietComfort Headphones
- iPad Pro
- Logitech MX Master Mouse
- Logitech C920 Webcam

The star of the show is my keyboard, which I really enjoy. MX clears are comfortable, and not too loud with the o-rings installed. The next best purchase I’ve made would be the headphone stand. Super cheap, well made, holds the my noise canceling headphones, and has 3 USB 3.0 ports. To be honest, the reason why the headphone stand is my next best purchase is because having a USB hub is new for me, and easy access to my flash drives and Yubikey’s are a big plus. Typically I use my iPad to steam music and podcasts to the Wren bluetooth speaker, and I use my headphones for Skype / Hangouts meetings. The Bose QC’s are the older, wired model, but the noise canceling is top notch. Great for just putting on even to block out lawn mowers and the like.
