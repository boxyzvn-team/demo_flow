# Claude Code Project Guidelines

## 📌 Repository Configuration

```
REPO_URL: git@github.com:boxyzvn-team/demo_flow.git
DEFAULT_BRANCH: master
BASE_BRANCH: develop
REMOTE: origin
```

**Trước khi bắt đầu bất kỳ task nào, kiểm tra remote:**
```bash
git remote -v
```

**Nếu chưa có remote, thêm ngay:**
```bash
git remote add origin <SSH_URL>
```

---

## 🚨 Git Workflow - BẮT BUỘC TUÂN THỦ

### A. Bắt đầu Task Mới

1. **Fetch và checkout base branch:**
   ```bash
   git fetch origin
   git checkout develop
   git pull origin develop
   ```

2. **Tạo branch mới:**
   ```bash
   git checkout -b ai/<your-name>/<type>-<ticket>-<description>
   ```

3. **Push branch lên origin ngay lập tức** (để tracking):
   ```bash
   git push -u origin HEAD
   ```

4. **Tạo session log:**
   ```bash
   mkdir -p .ai/sessions
   ```
   
   Tạo file `.ai/sessions/YYYY-MM-DD-<ticket>.md`:
   ```markdown
   # Session: <ticket> - <description>
   - Developer: <name>
   - Started: <YYYY-MM-DD HH:mm>
   - Branch: <branch-name>
   - Repository: <SSH_URL>
   
   ## Prompts & Actions
   ```

5. **Commit và push khởi tạo:**
   ```bash
   git add .
   git commit -m "[AI] chore: khởi tạo session <ticket>"
   git push
   ```

---

### B. Trong Quá Trình Làm Việc

#### ✅ PHẢI Commit Ngay Sau Khi:
- Tạo file mới hoặc xóa file
- Hoàn thành một function hoặc component
- Fix một bug cụ thể
- Thêm hoặc sửa tests
- Refactor một phần code
- Thay đổi config hoặc dependencies

#### ❌ KHÔNG ĐƯỢC:
- Gom tất cả thay đổi vào 1 commit cuối
- Viết commit message chung chung như "update code"
- Tiếp tục code khi có >5 files chưa commit
- Quên push lên origin

#### Commit Message Format:

```
[AI] <type>: <mô tả ngắn gọn>

- Chi tiết thay đổi 1
- Chi tiết thay đổi 2

Prompt: "<tóm tắt prompt từ user>"
```

**Type values:**
| Type | Khi nào dùng |
|------|--------------|
| `feat` | Thêm tính năng mới |
| `fix` | Sửa bug |
| `refactor` | Cải thiện code không đổi behavior |
| `test` | Thêm hoặc sửa tests |
| `docs` | Documentation |
| `chore` | Config, dependencies |

**Ví dụ commit message tốt:**
```
[AI] feat: thêm validateToken middleware

- Tạo middleware kiểm tra JWT token
- Xử lý expired, invalid, missing token cases
- Trả về 401 với error message rõ ràng

Prompt: "thêm middleware xác thực JWT"
```

#### 🔄 Push Rules - QUAN TRỌNG:

**PHẢI push lên origin sau mỗi commit:**
```bash
git add .
git commit -m "[AI] <type>: <message>"
git push
```

**Hoặc tối thiểu push sau mỗi 2-3 commits:**
```bash
git push origin HEAD
```

**Kiểm tra đã push chưa:**
```bash
git status
# Nếu thấy "Your branch is ahead of 'origin/...'" → cần push ngay
```

#### Update Session Log:

Sau mỗi commit, thêm vào session log file:

```markdown
### Prompt N
> <nội dung prompt>

**Action:** <mô tả việc đã làm>
**Files:** <danh sách files changed>
**Commit:** <commit hash - 7 ký tự đầu>
**Pushed:** ✅
```

---

### C. Kết Thúc Task

1. **Hoàn thành session log** - thêm Summary:
   ```markdown
   ## Summary
   - Total commits: <số>
   - Total prompts: <số>
   - Session duration: <thời gian>
   - Status: Ready for review
   - All commits pushed: ✅
   ```

2. **Commit session log:**
   ```bash
   git add .ai/sessions/
   git commit -m "[AI] docs: hoàn thành session log <ticket>"
   ```

3. **Final push:**
   ```bash
   git push origin HEAD
   ```

4. **Verify tất cả đã push:**
   ```bash
   git log origin/$(git branch --show-current)..HEAD
   # Nếu output rỗng → tất cả đã push ✅
   # Nếu có commits → cần push thêm
   ```

5. **Tạo Pull Request** vào `develop`:
   ```markdown
   ## Summary
   <Mô tả task>
   
   ## AI Session
   - Session log: `.ai/sessions/<file>.md`
   - Commits: <số lượng>
   - Prompts: <số lượng>
   
   ## Changes
   - <Thay đổi 1>
   - <Thay đổi 2>
   
   ## Checklist
   - [ ] All commits have [AI] prefix
   - [ ] Session log complete
   - [ ] All commits pushed to origin
   - [ ] Tests pass
   ```

---

## 🔍 Self-Check Trước Mỗi Commit

1. ✅ Thay đổi này có ý nghĩa độc lập không?
2. ✅ Commit message mô tả rõ WHAT và WHY?
3. ✅ Đã include prompt context?
4. ✅ Có quá nhiều files (>10) trong 1 commit không?

## 🔍 Self-Check Sau Mỗi Commit

1. ✅ Đã push lên origin chưa?
2. ✅ Đã update session log chưa?

---

## 📁 Project Structure

```
project/
├── .ai/
│   └── sessions/
│       ├── 2024-01-15-TASK-001.md
│       └── 2024-01-16-TASK-002.md
├── CLAUDE.md          ← File này
├── src/
└── ...
```

---

## 🏷️ Branch Naming

```
ai/<developer>/<type>-<ticket>-<short-description>
```

**Base branch:** `develop`
**Merge target:** `develop` → sau đó merge vào `master`

**Ví dụ:**
- `ai/alice/feat-AUTH-001-user-login`
- `ai/bob/fix-BUG-042-null-pointer`
- `ai/carol/refactor-TECH-015-database`

---

## ⚠️ Troubleshooting

### Push bị reject
```bash
git pull --rebase origin $(git branch --show-current)
git push
```

### Quên push nhiều commits
```bash
# Kiểm tra commits chưa push
git log origin/$(git branch --show-current)..HEAD --oneline

# Push tất cả
git push origin HEAD
```

### Remote chưa được set
```bash
git remote add origin <SSH_URL>
git push -u origin HEAD
```
