# Understanding SSL Misconfiguration

## Introduction
To be honest, it’s relatively infuriating in 2015 to see so many sites that have misconfigured SSL.

**Everyone** (including you business folks!) should have a basic understanding of how secure connections on the internet works. 

The goal is to have anyone understand it’s importance, the basic parts of SSL, and very quickly understand if you are doing it wrong. 

----

## HTTP vs HTTPS
HTTP is a protocol that is used for communicating with web servers. Just as a recap - **HTTP** & **HTTPS** are different. The `S` stands for secure. The most important thing for you to know is that they are SEPARATE protocols.

----

## What are SSL and TLS?
SSL (Secure Sockets Layer) and TLS (Transport Layer Security) are mechanisms for safely transmitting data. On the web, SSL and TLS try to do two things:
- Encrypt and verify the integrity of traffic between the browser and the server.
- Verify that the browser is talking to the correct server. In practice, this usually means verifying that the owner of the domain and the owner of the server are the same entity. This helps prevent man-in-the-middle attacks. Without it there's no guarantee that you're encrypting traffic to the right recipient.
The SSL protocol is both outdated and insecure, and has since been replaced by TLS. However, the term "SSL" continues to be used colloquially to refer to the general mechanism for protecting transmitted data.

To prepare a web server to accept HTTPS connections (remember this is different than HTTP), a public key certificate must be created for the web server. This certificate must be signed by a trusted certificate authority (a trusted third party) for the web browser to accept it without warning. Web browsers are distributed with a list of signing certificates of major certificate authorities so that they can verify certificates signed by them. 

Read more: http://en.wikipedia.org/wiki/HTTPS

----

## If you are non-technical… Use SSL Labs and call it good.
Go to https://www.ssllabs.com/ssltest/  … fill in your domain name, and click submit. Soon you will have an A-F score for how well your SSL is configured! Print out that page, and bring it to your web guy. If you’re unsure, drop me an email at sam@snelling.io and I’ll help you get started. 

… This is where I leave you. Keep reading if you are more technical :)

----

## If you are more technical…
Awesome, I know I’ve slow played you so far, but let’s jump into things. I’ll say it again just because it is worth repeating… SSL Labs is a great place to start to get a good frame of reference -> https://www.ssllabs.com/ssltest/

----

## Recommended configurations
At https://wiki.mozilla.org/Security/Server_Side_TLS, Mozilla has a few recommended configurations:
- **Modern** `Firefox 27, Chrome 22, IE 11, Opera 14, Safari 7, Android 4.4, Java 8`
- **Intermediate** `Firefox 1, Chrome 1, IE 7, Opera 5, Safari 1, Windows XP IE8, Android 2.3, Java 7`
- **Old** `Windows XP IE6, Java 6`

Let’s be real here, you should be at least targeting Intermediate in 2015. 

Okay, what do we need to be looking at in your configuration? A few things:
- Ciphersuite
- SSL & TLS Version
- RSA Key Size
- DH Parameter Size
- Elliptic curve
- Certificate signature
- HSTS
- Forward Secrecy

… My goodness that’s a lot to wrap your head around. Let’s try and simplify it.

----

## Cipher suites
Via http://en.wikipedia.org/wiki/Cipher_suite
> A cipher suite is a named combination of authentication, encryption, message authentication code (MAC) and key exchange algorithms used to negotiate the security settings for a network connection using the Transport Layer Security (TLS) / Secure Sockets Layer (SSL) network protocol.

**What you need to know:** the web browser sends a list of supported *cipher suites* to the web server with an order of preference, and the server responds with cipher suite it selected from the list.

----

## SSL & TLS Versions
There’s SSLv1, SSLv2, SSLv3, TLS 1, TLS 1.1, TLS 1.2. *Wipes brow*

**What you need to know:** Don’t support SSLv1, SSLv2 or SSLv3. Why? SSL 1 & 2 were deprecated long ago, so it’s a non issue. SSL 3 is vulnerable to several exploits, so disable it. If you’re going to only target the newest browsers, you can also drop support for TLS 1 (do some research if this is right for you).

----

## RSA Key Size
Via http://en.wikipedia.org/wiki/RSA_(cryptosystem)
>In cryptography, key size or key length is the size measured in bits of the key used in a cryptographic algorithm. 

Via http://en.wikipedia.org/wiki/RSA_(cryptosystem)
>RSA is one of the first practicable public-key cryptosystems and is widely used for secure data transmission. In such a cryptosystem, the encryption key is public and differs from the decryption key which is kept secret.

**What you need to know:** Make your RSA Key Size 2048. According to RSA, the 2048 key size should be safe until year 2030 (ish) whereas a key size of 1024 is already insecure.

----

## DH Parameter Size
While I could get into the intricacies of the Diffie-Hellman algorithm, bits of prime, and `DHE_RSA` cipher suites , I’m just going to give you what you need to know here.

**What you need to know:** Make the DH Parameter Size the same as your RSA Key Size. Recommendation is 2048! With that said, if your RSA Key Size is 1024, make your DH Parameter Size 1024, because it will not increase your security and you will have to pay for an extra large key.

----

## Elliptic curve
Via http://en.wikipedia.org/wiki/Elliptic_curve_cryptography
>Elliptic curve cryptography (ECC) is an approach to public-key cryptography based on the algebraic structure of elliptic curves over finite fields. 
>Public-key cryptography is based on the intractability of certain mathematical problems.

**What you need to know:** Set the elliptic curve to secp256r1, secp384r1, secp521r1 (at a minimum).

----

## Certificate signature
The certificate signature is essentially a hash of the certificate. It operates on the premise of a digital signature to verify authenticity. 

**What you need to know:** If you need to support Windows XP (before Service Pack 3), you need to use SHA-1. If you don’t need to support that, use SHA-256. I repeat, **use SHA-256**.

----

## HSTS
HSTS is a HTTP header that states how long to continue using HTTPS for.
 Sample HSTS header:
```
Strict-Transport-Security: max-age=15724800
```

**What you need to know:**  Use it if you’re planning on supporting HTTPS forever. So use it.

----

## Forward Secrecy
Forward secrecy allows the web browser and server to negotiate a key that never hits the wire, and is destroyed at the end of the session. This makes the only way to decrypt the communication is to break the session keys themselves.

Enabling forward secrecy can be done in two steps:
- Configure your server to actively select the most desirable suite from the list offered by SSL clients.
- Put ECDHE and DHE suites to the top of your list. (The order is important; because ECDHE suites are faster, you want to use them whenever clients supports them.)

**What you need to know:**  If you go with one of the Mozilla recommended configurations, you support forward secrecy.

----

## Vulnerabilities
I’m not going to go into this super in depth because the scope has already creeped quite a bit, but here are a list of vulnerabilities and where you can read more:

BEAST 
- https://blog.torproject.org/blog/tor-and-beast-ssl-attack

LUCKY13 
- https://www.imperialviolet.org/2013/02/04/luckythirteen.html

CRIME
- https://community.qualys.com/blogs/securitylabs/2012/09/14/crime-information-leakage-attack-against-ssltls

BREACH
- http://breachattack.com

POODLE
- https://tls.mbed.org/tech-updates/blog/sslv3-and-poodle-in-perspective

Sam’s note: What stupid fucking names for vulnerabilities.

----

## DO NOT USE
Things you should stop using… from Mozilla:
- `aNULL` contains non-authenticated Diffie-Hellman key exchanges, that are subject to Man-In-The-Middle (MITM) attacks
- `eNULL` contains null-encryption ciphers (cleartext)
- `EXPORT` are legacy weak ciphers that were marked as exportable by US law
- `RC4` contains ciphers that use the deprecated ARCFOUR algorithm
- `DES` contains ciphers that use the deprecated Data Encryption Standard
- `SSLv2` contains all ciphers that were defined in the old version of the SSL standard, now deprecated
- `MD5` contains all the ciphers that use the deprecated message digest 5 as the hashing algorithm

----

## Mozilla Again
I’m just going to leave this here… because it’s that important.
`https://wiki.mozilla.org/Security/Server\_Side\_TLS`

----

## Tools
If you’ve made it this far, congratulations. You may need to know way more than you need to, or you may have skimmed to the bottom. Either way, let’s get into some of the neat tools to help you configure and test your SSL setup.

----

## DNSimple SSL installation wizard
If you’re a customer of DNSimple, use the configuration wizard. Enough said. 

http://blog.dnsimple.com/2014/10/ssl-certificate-installation-wizard/

----

## Cloudflare SSL
Cloud flare cannot make it any brain dead simple for you to add SSL. I use Cloudflare Full SSL (strict). There’s no excuse for at least setting up their Universal SSL.

 https://www.cloudflare.com/ssl

----

## Mozilla SSL Configuration Generator
If you’re setting up your SSL configuration from scratch, just use the super cool Mozilla generator and call it good. It supports Apache, Nginx, & HAProxy.

https://mozilla.github.io/server-side-tls/ssl-config-generator/

----

## SSL Labs
SSL Labs: https://www.ssllabs.com/ssltest/

Also rebranded by GlobalSign here: https://sslcheck.globalsign.com/en_US

----

## Cipherscan
Holy shit, I’ve finally made it to Cipherscan, which was the whole reason I started this ridiculous article to begin with.

>Cipherscan tests the ordering of the SSL/TLS ciphers on a given target, for all major versions of SSL and TLS. It also extracts some certificates informations, TLS options, OCSP stapling and more. Cipherscan is a wrapper above the `openssl s_client` command line.

Let’s get it installed. Using Yosemite, open up your terminal and install `bash` and `coreutils` via homebrew:
- `$ brew install bash`
- `$ brew install coreutils`

Next, clone the Cipherscan repo, and change into it’s directory:
- `$ git clone https://github.com/jvehent/cipherscan.git`
- `$ cd cipherscan`

Perfect! There’s a lot we can do with Cipherscan, but all we’re going to use it for is testing the a site, and looking at what we can do to improve our configuration.

Go ahead and try a command with the following structure:
`cipherscan$  ./cipherscan DOMAIN.COM`

**Example:** ` ./cipherscan snelling.io`

**Response:**
```
Target: snelling.io:443

prio  ciphersuite                  protocols              pfs_keysize
1     ECDHE-RSA-AES128-GCM-SHA256  TLSv1.2                ECDH,P-256,256bits
2     ECDHE-RSA-AES128-SHA256      TLSv1.2                ECDH,P-256,256bits
3     ECDHE-RSA-AES128-SHA         TLSv1,TLSv1.1,TLSv1.2  ECDH,P-256,256bits
4     AES128-GCM-SHA256            TLSv1.2
5     AES128-SHA256                TLSv1.2
6     AES128-SHA                   TLSv1,TLSv1.1,TLSv1.2
7     ECDHE-RSA-AES256-GCM-SHA384  TLSv1.2                ECDH,P-256,256bits
8     ECDHE-RSA-AES256-SHA384      TLSv1.2                ECDH,P-256,256bits
9     ECDHE-RSA-AES256-SHA         TLSv1,TLSv1.1,TLSv1.2  ECDH,P-256,256bits
10    AES256-GCM-SHA384            TLSv1.2
11    AES256-SHA256                TLSv1.2
12    AES256-SHA                   TLSv1,TLSv1.1,TLSv1.2
13    ECDHE-RSA-DES-CBC3-SHA       TLSv1,TLSv1.1,TLSv1.2  ECDH,P-256,256bits
14    DES-CBC3-SHA                 TLSv1,TLSv1.1,TLSv1.2

Certificate: trusted, 2048 bit, sha1WithRSAEncryption signature
TLS ticket lifetime hint: 64800
OCSP stapling: not supported
Server side cipher ordering
```

So what does this tell us? It tells us exactly what cipher suites and protocols I use. Neat. Cloudflare is the top layer here, so that’s really what we’re seeing, but I digress.

The truth is, this really means absolutely nothing to most people, so let’s try the second command with the following structure:
`cipherscan$  ./analyze.py -t DOMAIN.COM`

**Example:** ` ./analyze.py -t snelling.io`

**Response:**
```
snelling.io:443 has obscure or unknown ssl/tls

Changes needed to match the old level:
* consider enabling SSLv3

Changes needed to match the intermediate level:
* remove cipher ECDHE-RSA-DES-CBC3-SHA
* consider using a SHA-256 certificate

Changes needed to match the modern level:
* remove cipher AES128-GCM-SHA256
* remove cipher AES128-SHA256
* remove cipher AES128-SHA
* remove cipher AES256-GCM-SHA384
* remove cipher AES256-SHA256
* remove cipher AES256-SHA
* remove cipher ECDHE-RSA-DES-CBC3-SHA
* remove cipher DES-CBC3-SHA
* disable TLSv1
* use a SHA-256 certificate
```

So http://snelling.io doesn’t match any of the Mozilla recommended levels per se, but it doesn’t return anything bad! Hey oh. Looks like CloudFlare is good enough to not have any vulnerabilities. 

[![Screenshot 2015-03-15 22.51.49.png](images/l5eq81lk1twq.png)](images/l5eq81lk1twq.png)


Okay, to just show what kind of actionable results we can get out of this analyze query, how about we use it on something insecure, like our local Tinker Federal Credit Union Bank!

**Query:** ` ./analyze.py -t tinkerfcu.org`

**Response:**

```
tinkerfcu.org:443 has bad ssl/tls

Things that are bad:
* remove cipher RC4-SHA
* remove cipher RC4-MD5
* remove cipher DES-CBC3-MD5
* disable SSLv2
* don't use an untrusted or self-signed certificate
```

Just to be sure, let’s run a quick SSL Labs scan.

[![Screenshot 2015-03-15 22.18.03.png](images/aplmuwunspxqq.png)](images/aplmuwunspxqq.png)

Okay, so banks SSL might not be as great as we originally thought. Hm. But surely an IT Department at a higher learning institution can get this right…

**Example:** ` ./analyze.py -t app.it.okstate.edu`

**Response:**
```
app.it.okstate.edu:443 has bad ssl/tls

Things that are bad:
* remove cipher RC4-SHA
* remove cipher RC4-MD5
* remove cipher EDH-RSA-DES-CBC3-SHA
* remove cipher EDH-RSA-DES-CBC-SHA
* remove cipher DES-CBC-SHA
* remove cipher EXP-EDH-RSA-DES-CBC-SHA
* remove cipher EXP-DES-CBC-SHA
* remove cipher EXP-RC2-CBC-MD5
* remove cipher EXP-RC4-MD5
* remove cipher RC2-CBC-MD5
* remove cipher DES-CBC3-MD5
* remove cipher DES-CBC-MD5
* disable SSLv2
* don't use an untrusted or self-signed certificate
* don't use DHE smaller than 1024bits or ECC smaller than 160bits

```

[![Screenshot 2015-03-15 22.23.11.png](images/7mwvkhq2mj2thw.png)](images/7mwvkhq2mj2thw.png)

... They really make it too easy to clown on them.

----

#Conclusion

We shouldn’t tolerate insecure bullshit connections from banks and other websites. At the end of the day, use the tools and standard configurations to help aid the process. There are plenty of tools here to get you started down the right path in checking your own configuration.

Interested in hearing thoughts on twitter @snellingio.