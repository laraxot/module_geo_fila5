---
name: semantic-versioning
description: Manage semantic versioning GitHub Actions and build provenance attestation for modules and themes. Ensures every module has proper CI/CD with automatic tagging, SLSA provenance via actions/attest-build-provenance@v3, and release management.
---

# Semantic Versioning & Build Provenance

Manage GitHub Actions for automatic semantic versioning with SLSA build provenance attestation.

## When to Use

- When creating a new module or theme
- When checking CI/CD configuration
- When the user asks about versioning, releases, or GitHub Actions
- When auditing module completeness

## Required Files per Module/Theme

Each module/theme MUST have:

1. `.github/workflows/semantic-versioning.yml` - Automatic version tagging with provenance
2. `.releaserc.json` - Semantic release configuration

## Template: semantic-versioning.yml (Module)

Location: `Modules/{Module}/.github/workflows/semantic-versioning.yml`

```yaml
name: Semantic Versioning

on:
  workflow_dispatch:
  push:
    branches:
      - main
      - dev

permissions:
  contents: write
  id-token: write
  attestations: write
  artifact-metadata: write

jobs:
  tag:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
        with:
          fetch-depth: 0
      - name: Build module artifact
        run: tar -czf module-artifact.tgz .
      - name: Attest build provenance
        uses: actions/attest-build-provenance@v3
        with:
          subject-path: module-artifact.tgz
      - name: Bump version and push tag
        id: tag_version
        uses: mathieudutour/github-tag-action@v6.2
        with:
          github_token: ${{ secrets.GITHUB_TOKEN }}
          fetch_all_tags: true
          release_branches: main,dev
```

## Template: semantic-versioning.yml (Theme)

Same as module but with:
- Step name: `Build theme artifact`
- Artifact: `theme-artifact.tgz`

## Template: .releaserc.json

```json
{
  "branches": ["main", "master"],
  "plugins": [
    "@semantic-release/commit-analyzer",
    "@semantic-release/release-notes-generator",
    "@semantic-release/github"
  ]
}
```

## Build Provenance (actions/attest-build-provenance@v3)

### What It Does
- Creates SLSA build provenance attestations using in-toto format
- Signs artifacts with short-lived Sigstore certificates
- Provides verifiable supply chain security
- Uploads attestations to GitHub's attestations API
- Public repos use Sigstore public-good instance; private repos use GitHub's private instance

### Required Permissions
```yaml
permissions:
  id-token: write           # OIDC token for Sigstore certificate
  attestations: write       # Persist attestations
  artifact-metadata: write  # Generate storage records (optional)
```

### Supported Artifact Types
- **Files**: Individual files or wildcards (`dist/**/my-bin-*`)
- **Container Images**: Fully-qualified names with digest
- **Checksums**: shasum format files (compatible with GoReleaser/JReleaser)
- **Upload Artifact**: Via `sha256:${{ steps.upload.outputs.artifact-digest }}`

### Inputs
| Input | Purpose | Required |
|-------|---------|----------|
| `subject-path` | File path(s) to attest (glob supported) | One of three |
| `subject-digest` | SHA256 digest (`sha256:hex_digest`) | One of three |
| `subject-checksums` | Path to checksums file | One of three |
| `push-to-registry` | Push to container registry | No (default: false) |
| `show-summary` | Display in workflow summary | No (default: true) |

### Outputs
| Output | Description |
|--------|-------------|
| `attestation-id` | GitHub ID for attestation |
| `attestation-url` | Summary page URL |
| `bundle-path` | Local path to attestation file |

### Verification
```bash
gh attestation verify <artifact-path>
```

## Commit Message Convention

For semantic versioning to work correctly:
- `feat:` - New feature (MINOR version bump)
- `fix:` - Bug fix (PATCH version bump)
- `feat!:` or `BREAKING CHANGE:` - Breaking change (MAJOR version bump)
- `docs:`, `chore:`, `style:`, `refactor:`, `test:` - No version bump

## Checklist for New Modules

1. Create `.github/workflows/semantic-versioning.yml`
2. Create `.releaserc.json`
3. Verify permissions include `id-token: write`, `attestations: write`
4. First push to main/dev triggers initial version tag
5. Verify attestation with `gh attestation verify`
