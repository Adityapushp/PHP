XKCD Daily Email Subscription ☄️
A fun, zero-database PHP project to get an XKCD comic in your inbox—every day!

Subscribe, verify, enjoy daily XKCD comics, and unsubscribe with one click. All lightning-fast, all in one directory.

<p align="center"> <img src="https://imgs.xkcd.com/static/terrible_small_logo.png" alt="XKCD Logo" width="120"> </p>
🚀 Features
Simple Email Signup & Verification:
Enter your email, receive a 6-digit code, and you’re in!

Beautiful HTML Daily Comic Mails:
Every 24 hours, a random XKCD comic lands in your inbox—complete with image, title, and joke!

One-Click Unsubscribe:
Instant opt-out, confirmation by code, always in your control.

No Database Needed:
Clean, readable storage: just a registered_emails.txt flat file.

Super-Easy CRON Setup:
Auto-configure daily comic delivery with a single script.

🗺️ How It Works
1. Quick Registration
Enter your email address on the main page.

Receive a 6-digit code by email.

Enter the code to confirm—you’re now subscribed!

2. Enjoy Daily Random XKCDs 💌
Once you’re in, you get a handpicked random XKCD comic every 24 hours with a comic image, in a crisp HTML email.

3. Hassle-Free Unsubscription
Each email has a visible unsubscribe link.

Click it, enter your email, and confirm via code—done!

📂 File Structure
text
src/
  ├─ index.php               # Signup & verification page
  ├─ unsubscribe.php         # Unsub link handler and logic
  ├─ functions.php           # Email, validation, XKCD logic lives here
  ├─ cron.php                # Sends daily XKCD emails to subscribers
  ├─ setup_cron.sh           # Auto-schedules cron.php for you
  └─ registered_emails.txt   # All active subscriber emails
⚡ Get Started in 30 Seconds
1. Clone and Branch

bash
git clone https://github.com/rtlearn/xkcd-Adityapushp.git
cd xkcd-Adityapushp
git checkout -b your-feature-branch
2. PHP Ready? (8.3+)

3. Supercharge with CRON

bash
cd src/
chmod +x setup_cron.sh
./setup_cron.sh
This command sets up your system to send daily XKCDs—no manual steps needed!

4. Serve src/ with your favorite web server.

✨ Usage
Register
<input type="email" name="email" required> <button id="submit-email">Submit</button>

Verify
<input type="text" name="verification_code" maxlength="6" required> <button id="submit-verification">Verify</button>

Unsubscribe
<input type="email" name="unsubscribe_email" required> <button id="submit-unsubscribe">Unsubscribe</button>

Unsubscribe Code
<input type="text" name="verification_code" maxlength="6" required> <button id="submit-verification">Verify</button>

📧 Email Templates
Verification:
<p>Your verification code is: <strong>123456</strong></p>

Comic Email:
<h2>XKCD Comic</h2> <img src="image_url_here" alt="XKCD Comic"> <p><a href="#">Unsubscribe</a></p>

Unsubscribe Confirmation:
<p>To confirm un-subscription, use this code: <strong>654321</strong></p>

All emails are delivered as beautifully formatted HTML and always with clear instructions!

⚠️ Submission & Contribution Guidelines
Don't change file structure, required stubs, or go outside src/.

Do not use hardcoded emails or codes, or any database.

Important: All forms and buttons must remain visible at all times.

One pull request per submission.

💡 Developer Notes
Verification codes: Always 6 random digits.

Mailing: Uses the built-in PHP mail() with perfect HTML output.

Subscribers: Just a simple text file—flat, fast, easy!

🙏 Credits & License
Inspired by XKCD Comics

Assignment by RTLearn

MIT License (by default; or as licensed in the repo)

<p align="center"> <img src="https://imgs.xkcd.com/comics/devotion_to_duty.png" alt="Sample XKCD Comic" width="270"> </p>
“For questions, bug reports, or ideas—open a GitHub Issue!”

Laugh. Learn. XKCD delivered.
