## Relevant Files

- `README.md` - The main report file to be created/updated at the root of the repository.
- `Original/Task.md` - Contains grading requirements and guidelines for the report.
- `tasks/tasks-security-hardening.md` - Reference for the security enhancements that were completed.
- `Original/` - Directory containing original codebase files to extract "before" snippets.
- `Enhanced/` - Directory containing hardened codebase files to extract "after" snippets.

### Notes

- This task list focuses on completing Milestone 3: The Markdown Report (README.md).
- Refer to both `Original/` and `Enhanced/` directories to extract precise before/after code snippets.
- Ensure that the report reflects the actual code edits accurately to avoid losing marks.

## Instructions for Completing Tasks

**IMPORTANT:** As you complete each task, you must check it off in this markdown file by changing `- [ ]` to `- [x]`. This helps track progress and ensures you don't skip any steps.

Example:
- `- [ ] 1.1 Read file` → `- [x] 1.1 Read file` (after completing)

Update the file after completing each sub-task, not just after completing an entire parent task.

## Tasks

- [ ] 0.0 Create feature branch
  - [ ] 0.1 Create and checkout a new branch for this feature (e.g., `git checkout -b feature/markdown-report`)
- [x] 1.0 Document Header Information and Context
  - [x] 1.1 Add project header details (Name, Matric Number, Web App Title) to `README.md`.
  - [x] 1.2 Write the context section containing a brief introduction of the WaqafHub web application.
  - [x] 1.3 Outline the security hardening objectives (why we are hardening the application).
- [x] 2.0 Document Security Enhancements with Before/After Code Snippets
  - [x] 2.1 Document "Input Validation" section, comparing original code with enhanced server/client-side validation.
  - [x] 2.2 Document "Authentication Hardening" section, showing password hashing and session security configuration differences.
  - [x] 2.3 Document "Authorization / RBAC" section, detailing role definitions and route protection middleware.
  - [x] 2.4 Document "XSS & CSRF Prevention" section, demonstrating form tokens and secure Blade rendering.
  - [x] 2.5 Document "Database Security" section, highlighting parameterization and elimination of raw SQL queries.
  - [x] 2.6 Document "File Security & Web Server Config" section, showing environment configuration adjustments and direct access prevention.
- [x] 3.0 Add Academic and Industry References
  - [x] 3.1 Gather academic or industry resources (such as OWASP guidelines, Laravel security standards) relevant to each implemented security domain.
  - [x] 3.2 Add the references section to `README.md` in a consistent bibliography format.
- [x] 4.0 Review, Format, and Finalize the README.md Report
  - [x] 4.1 Verify all file links, formatting, and markdown layout in the completed `README.md`.
  - [x] 4.2 Validate that code snippets match the actual source files in `Original/` and `Enhanced/`.
  - [x] 4.3 Copy the GitHub repository URL and prepare for submission.
