Midterm - Practical

Hide Assignment Information
Instructions
Mid-Term Practical: Designing & Implementing a CI Pipeline with GitHub Actions Or Jenkins

Overview
In this assignment, you will create a Continuous Integration (CI) pipeline using GitHub Actions OR Jenkins (with Multi-Environment deployment approach). The pipeline must include stages for Build, Test, Lint/Quality Checks, and Upload artifacts/docker image phase for a sample application. And it should support multi-environment deployment (e.g., dev, prod).

Note
The choice of the Project/Technology for this exam CANNOT be same as your Assignment 1 or Lab 1-2.

Objectives
Apply the principles of Continuous Integration.
Implement a CI pipeline using GitHub Actions OR Jenkins.
Perform quality checks (e.g. Linting or static analysis).
Implement multi-environment deployments (dev, prod, etc.).
Create a Docker image and publish it to a registry OR just publish application artifacts to a Storage solution like S3 bucket.
Document the CI workflow clearly in a README.md
Assignment Details
Project Setup (2%)

Create a new repository on GitHub.
Initialize it with a sample application (you CANNOT use the application you already used in Assignment 1 OR Lab 1-2).
Include at least one feature branch (e.g., develop, ci-test, or feature/xyz).
CI Pipeline with GitHub Actions or Jenkins (14%)

Create a .github/workflows/ci.yml OR Jenkinsfile file in your repository.
Your CI pipeline should include the following:
Build Stage (3%)
Install necessary dependencies.
Compile or build the application (if applicable).
Fail the pipeline on build errors.
Test Stage (4%)
Write and run at least 4 unit tests.
Ensure that the pipeline fails if any tests do not pass.
Optional: Add a test coverage or CI status badge in your README.
Lint/Static Analysis (2%)
Integrate a linter (e.g., ESLint, Flake8) or static analysis tool.
Fail the pipeline on critical issues or errors.
Upload Phase - ONE of the following (5%)
Build and upload Docker image to a registry of your choice
Build and upload project artifacts as a ZIP to a storage solution like S3 bucket
Multi-Environment Deployment (4%)

Your CI pipeline must support at least two deployment environments:

dev: Automatically triggered on pushes to develop.
prod: Manually triggered (via workflow_dispatch, Jenkins parameter, or main branch merge).
Environment-specific deployment actions:
Use different tags or paths (e.g., my-app:dev vs. my-app:latest, or s3://my-bucket/dev/ vs. /prod/).
Optionally use .env.dev and .env.prod or config folders.
Documentation & Repository Hygiene (4%)

Provide a detailed README.md (3%) with:
Project setup & dependencies.
CI pipeline description and instructions to trigger it.
Docker image pull/run instructions (if applicable).
Jenkins instructions (if implemented).
Clean code structure, .gitignore, and organized repo (1%).
Submission Guidelines
Push your changes to your OWN GitHub repository.
Submit a link to your GitHub repository along with a detailed README.
Screenshots, wherever necessary to demonstrate your work.
Good luck, and have fun building your CI pipeline(s)!

Due on Jun 21, 2025 11:59 PM
Available on Jun 13, 2025 12:00 PM. Hidden before availability starts.
Available until Jun 22, 2025 11:59 PM. Access restricted after availability ends.
