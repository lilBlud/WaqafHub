Alright, let's break this down. Vibecoding the security features is a solid way to move fast, but because this is an Information Assurance project, we need to make sure your "vibes" are backed up by airtight logic and strict evidence. The project is worth **35% of your total grade**, split across the documentation, the code itself, and a slide-free presentation.

Since your app is currently only running locally, that is perfectly fine! The prompt focuses on your code structure and server configurations rather than requiring a live cloud deployment.

Here is the strategic milestone roadmap to take this from a local prototype to a fully hardened, submission-ready project.

---

## The Master Grade Breakdown

| Component | Weight | Key Deliverable | Crucial Rule |
| --- | --- | --- | --- |
| <br>**Project Report** 

 | 15% 

 | A highly detailed GitHub `README.md` file.

 | Must include exact code snippets, and your report *must* match your actual files or you'll lose marks.

 |
| <br>**Project Enhancement** 

 | 15% 

 | Clean GitHub repository with `Original` and `Enhanced` folders.

 | Both folders must maintain their Model-View-Controller (MVC) subfolder structures.

 |
| <br>**Project Presentation** 

 | 5% 

 | A 10-minute live presentation and Q&A session.

 | <br>**No PowerPoint slides allowed.** You will be sharing your screen and presenting the code/app directly.

 |

---

## Milestone Roadmap

### 🏁 Milestone 1: The Baseline & Repo Setup (Do this first!)

Before you touch a single line of security code, you need to preserve your "before" state so the grader can see the contrast.

* 
**Create your GitHub Repository**.


* 
**Setup the "Original" Folder:** Drop your old INFO 3305 web application files exactly as they are into a folder named `Original`. Ensure it has your standard MVC (Models, Views, Controllers) subfolders.


* 
**Setup the "Enhanced" Folder:** Clone that exact same MVC structure into a parallel folder named `Enhanced`. This is where your actual coding will happen.



### 💻 Milestone 2: The Security Hardening ("Vibecoding" Phase)

This is where you implement your security elements. As you write these, keep track of them because you will need to paste these exact code snippets into your report later. You need to tackle 6 specific domains:

* 1. Input Validation: Implement both client-side (for user experience) and server-side (for actual security) validation. Document the exact techniques used (e.g., regex, type checking).


* 2. Authentication: Implement secure login best practices (e.g., strong password hashing like bcrypt, session timeouts, or multi-factor if applicable).


* 3. Authorization: Set up role-based access control (RBAC). Ensure normal users can't access admin routes just by changing the URL.


* 4. XSS & CSRF Prevention: Sanitize all user inputs before rendering them back to the screen to stop Cross-Site Scripting (XSS). Use Anti-CSRF tokens on your forms to block Cross-Site Request Forgery.


* 5. Database Security: Swap out any raw SQL queries for prepared statements/parameterized queries to completely eliminate SQL Injection (SQLi) risks. Secure your database connection strings.


* 6. File Security & Web Server Config: Configure your environment settings to prevent directory traversal and file leaks. Make sure sensitive web server configuration files (like `.env`, `htaccess`, or nginx configs) are locked down.



### 📝 Milestone 3: The Markdown Report (`README.md`)

Your entire report lives inside the `README.md` at the root of your repository. Use clean Markdown formatting to make it highly scannable for the grader. It must include:

* [ ] **Header Info:** Your Name, Matric Number, and Web App Title.


* [ ] **Context:** An introduction to the web app and clear objectives explaining *why* you are hardening it.


* [ ] **The Meat of the Report:** For each of the 6 security areas above, explain what you did, the techniques used, and provide the **before/after code snippets** to prove it .


* [ ] **References:** Academic or industry sources (like OWASP guidelines) backing up your choices.


* [ ] **Submission:** Copy the GitHub link and submit it to iTaleem before the Week 14 deadline.



### 🎙️ Milestone 4: Presentation Prep (Week 14)

Since slides are banned, your prep for this is unique.

* 
**The Blueprint:** Plan a tight 10-minute walkthrough. Spend 2 minutes showing the app's basic utility, 6 minutes showing the "Enhanced" code snippets alongside a live demonstration of a security feature working, and save 2 minutes for the instructor's Q&A.



---

> ⚠️ **Critical Warning:** Do not forget to perform **server-side** input validation. A common trap when rushing is relying entirely on HTML5 frontend validation. If someone bypasses your frontend UI via a tool like Postman, your backend needs to catch it!
> 
> 

Which backend language and framework (e.g., Node.js/Express, PHP, Python/Django) did you use for the original INFO 3305 project so we can pinpoint exactly how to handle the database and session security?