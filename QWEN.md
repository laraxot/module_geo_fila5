## Qwen Added Memories
- Test rules: Use Pest format exclusively. NEVER use migrate:fresh or database:refresh in tests. Use DatabaseTransactions trait instead for proper transactional test isolation without schema rebuilds.
