# 正念·台灣 — 前端切版

純 HTML + CSS 靜態切版，供 Claude Code 開發時參考。

## 檔案結構

```
meditation-app/
├── style.css          # 全域樣式、Design Tokens、共用元件
├── index.html         # 首頁
├── meditation.html    # 冥想庫
├── tools.html         # 工具（白噪音、呼吸計時器、番茄鐘）
├── emotions.html      # 情緒日誌
└── profile.html       # 我的帳號
```

## Design Tokens（CSS 變數）

| 變數 | 值 | 用途 |
|------|-----|------|
| `--green` | #5A9E6E | 主色、按鈕、active 狀態 |
| `--green-light` | #E8F0E4 | 卡片背景、badge |
| `--bg` | #F7F5F0 | 頁面底色 |
| `--bg-secondary` | #EFEDE8 | Sidebar 底色 |
| `--border` | #E0DDD6 | 所有邊線 |
| `--dark` | #3A3530 | 升級 Banner、深色按鈕 |
| `--text` | #2C2C2A | 主要文字 |
| `--muted` | #999 | 次要文字 |

## Responsive

- **桌面（> 768px）**：左側 Sidebar 220px + 主內容區
- **手機（≤ 768px）**：Sidebar 隱藏，底部 Mobile Tab Bar 顯示

## 共用 Class 說明

- `.card` — 白色圓角卡片
- `.card-green` — 綠色淺底卡片（今日冥想用）
- `.btn-play` — 全寬綠色播放按鈕
- `.btn-lock` — 全寬灰色鎖定按鈕
- `.section-label` — 灰色大寫 section 標題
- `.tag.active / .tag.inactive` — 篩選 Tag
- `.noise-chip.active` — 白噪音選項
- `.grid-2 / .grid-3` — 兩欄 / 三欄 grid（手機自動變一欄）

## 開發建議

後續以 Next.js + Tailwind 開發時，可將：
- `style.css` 中的 `:root` 變數移入 `tailwind.config.ts`
- 各頁面 HTML 結構拆成 React 元件
- Sidebar / Mobile Nav 抽成 `<Layout>` 元件共用
- 番茄鐘邏輯（`tools.html` 內的 JS）移入 React `useState` + `useEffect`
