# Plugin: Recently Updated Dashboard Widget
**Fusion AI Coders Program Application**

## 1. Project Overview
* **Selected Option 1**: Dashboard Widget.
* **Why this option?** I chose this because it provides immediate value to WordPress.com customers by centralizing site change information. Monitoring plugin updates is a key part of site health, and this widget makes that data visible the moment a user logs in.

## 2. Tools Used
* **Primary AI Tool:** **Claude Code Opus 4.5** (CLI).
* **Environment:** Integrated within **VS Code** via the terminal.
* **Review Model:** I used **Gemini 3.0 Pro** to perform a secondary security and logic review of the code to ensure it follows basic security hygiene.

## 3. My Process & Learning
I approached this project by breaking it down into incremental steps to maintain a clear, logical Git history.

### The Development Steps:
1.  **Boilerplate & Security:** Established plugin headers and implemented security checks to prevent direct script access.
2.  **Widget Registration:** Used WordPress hooks to create the admin container.
3.  **Data Logic:** Developed logic to pull plugin data and filter for updates within the last 7 days.
4.  **UI & Escaping:** Formatted the output into an HTML list and applied proper escaping for security.
5.  **Feature Addition:** Added dates to show users when each plugin had been updated (along with the current version number).

## 4. Struggles & Solutions
* **The Learning Curve of Integration:** As someone who had never integrated AI tools into a coding workflow before, my biggest challenge was learning how to get all these moving parts to work together.
* **Git & GitHub:** Prior to this application, I had never used Git for writing and managing code. Learning the command line for staging and committing changes was fun!
* **The Solution:** I treated the process as a "learning lab." By making small, incremental commits, I was able to see exactly how my code evolved.
---------------------------------------------------------------------
## 5. How to Install & Test
### Installation
1.  Download this repository as a ZIP file.
2.  In your WordPress Admin, go to **Plugins > Add New > Upload Plugin**.
3.  Upload the ZIP and click **Activate**.
4.  Navigate to your **Dashboard**, where the "Recently Updated Plugins" widget should appear.

### Testing the Logic
If your site currently has no plugins updated within the last 7 days, the widget will display a "no updates" message. To test the functional list:
* I recommend downloading the **[WP Rollback](https://wordpress.org/plugins/wp-rollback/)** plugin.
* Use it to "rollback" a few plugins to an older version and then update them.
* This will trigger the logic in the widget so you can see the list of plugins that have been updated in the last 7 days.
