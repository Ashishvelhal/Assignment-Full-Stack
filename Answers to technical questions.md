# Technical Answers

## How long did you spend? What would you add?

I spent approximately **2–3 hours** on the implementation. During this time, I completed the following:

- Designed the database schema
- Implemented PHP APIs for categories and slides
- Built a responsive UI using tabs/accordion with a synced carousel
- Connected the carousel to images stored in the repository

### With additional time, I would add:
- A complete admin CRUD interface for managing categories and slides
- Image picker functionality with proper validation
- Admin authentication and access control
- Drag-and-drop ordering for slides
- Automated tests for reliability
- A Dockerized environment for easier setup and deployment

---

## How would you track down a performance issue in production? Have you done this?

To debug performance issues in production, I follow a systematic and data-driven approach:

### Step-by-step process:
1. Reproduce the issue and clearly define the scope using SLIs/SLOs  
2. Review APM dashboards, logs, and monitoring tools  
3. Check server resource usage: CPU, memory, and disk I/O  
4. Analyze database performance using slow query logs and `EXPLAIN` plans  
5. Investigate application traces using tools such as New Relic, Datadog, or OpenTelemetry  
6. Add targeted structured logs and timing markers around potential bottlenecks  
7. Use profiling tools like Xdebug or Blackfire in a staging environment with production-like data  
8. Identify and fix issues such as N+1 queries, missing indexes, inefficient queries, caching gaps, and large payload sizes  
9. Validate improvements through load testing and updated monitoring dashboards  

### Experience
Yes, I have worked on resolving production performance issues.  
Examples include fixing N+1 queries, adding appropriate database indexes, and implementing effective caching strategies, which led to noticeable improvements in p95 latency.

- **Describe yourself using JSON**
```json
{
  "name": "Ashish Velhal",
  "role": "Full Stack Developer",
  "experience_level": "Intermediate",
  "tech_stack": {
    "backend": ["PHP", "MySQL"],
    "frontend": ["JavaScript", "jQuery", "Bootstrap", "HTML5", "CSS3"],
    "tools": ["Git", "REST APIs", "cPanel"]
  },
  "professional_focus": [
    "building stable and maintainable systems",
    "designing clean and responsive UIs",
    "optimizing performance and user experience"
  ],
  "work_style": {
    "strengths": ["ownership mindset", "clear communication", "problem-solving", "iterative delivery"],
    "approach": "understand the requirement clearly, break it into small deliverables, and ship improvements quickly"
  },
  "interests": [
    "improving developer experience",
    "modernizing legacy codebases",
    "creating smooth and accessible interfaces"
  ],
  "fun_fact": "I genuinely enjoy transforming raw concepts into functional, user-friendly products."
}
