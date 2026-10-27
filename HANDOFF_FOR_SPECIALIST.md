# Handover & Deployment Guide for BetterWay

> **Project:** Artem Varganich — BetterWay (Personal Brand & Travel Club SPA)  
> **Registered Domain:** `thebetterway.top`  
> **Target Subdomain for Artem:** `artem.thebetterway.top`  
> **Git Repository:** `https://github.com/vargani4artem-boop/travel-club.git` (branch `main`)  
> **Live Staging/Demo:** `https://vargani4artem-boop.github.io/travel-club/`  
> **Standalone ZIP Archive:** `betterway_artem_site.zip` (~50.5 MB)

---

## 🤖 Готовый промпт для Antigravity (Скопировать и отправить AI-ассистенту)

```text
Привет! Мне нужно развернуть готовый сайт-портфолио и travel-клуб BetterWay (Артём Варганич) на наш собственный хостинг и привязать к нашему зарегистрированному домену.

Входные данные проекта:
1. Исходный код: GitHub-репозиторий https://github.com/vargani4artem-boop/travel-club.git (ветка main) или локальный архив betterway_artem_site.zip.
2. Технологический стек: Чистый статичный SPA (HTML5, Tailwind CSS через CDN, vanilla JavaScript, Lucide Icons, локальные видеофайлы MP4, WebP/PNG изображения). Сборка (npm build) не требуется — файлы отдаются веб-сервером напрямую.
3. Зарегистрированный домен проекта: thebetterway.top
4. Целевой поддомен для этого сайта: artem.thebetterway.top
5. Текущая рабочая демо-версия для сверки: https://vargani4artem-boop.github.io/travel-club/

Что нужно сделать:
1. Клонировать репозиторий или распаковать архив в директорию веб-сервера / хостинга.
2. Настроить конфигурацию веб-сервера (Nginx / Cloudflare Pages / Caddy / Apache) для поддомена artem.thebetterway.top с корректной отдачей статических файлов, mime-типов для video/mp4 и image/webp, и fallback на index.html.
3. Предоставить точные параметры DNS-записей для регистратора домена thebetterway.top (A/CNAME записи для artem.thebetterway.top).
4. Выпустить и настроить бесплатный SSL-сертификат (Let's Encrypt / Cloudflare SSL) с автоматическим перенаправлением с HTTP на HTTPS.
5. Проверить работоспособность мультиязычности (RU/EN), воспроизведение обоих видеороликов (1:26 на русском, 1:43 на английском), работу формы обратной связи и интерактивных галерей.
```

---

## 📁 Структура файлов проекта

- `index.html` — основной файл сайта (полная разметка, бренд BetterWay, переводы RU/EN, логика видеоплеера, интерактивные слайдеры, модальные окна, форма заявок).
- `artem_story.mp4` — русскоязычное видео (1 мин 26 сек).
- `artem_story_en.mp4` — англоязычное видео (1 мин 43 сек).
- `artem_video_cover.jpg` / `artem_video_cover_en.jpg` — постеры видео.
- `proof_*.png` — доказательства бронирования и клубной экономии в Пунта-Кане.
- `work_real_*.webp` — фотографии канадских рабочих будней.
- `life_real_*.webp` — фотографии путешествий и клубных событий.
- `lucide.min.js` — библиотека векторных иконок.

---

## 🌐 Настройка DNS-записей

В панели управления доменом **`thebetterway.top`**:

| Тип записи | Хост / Поддомен | Значение | TTL | Примечание |
| :--- | :--- | :--- | :--- | :--- |
| **A** (или **CNAME**) | `artem` | `IP вашего сервера` (или CNAME хостинга) | 3600 | Сайт Артёма: `artem.thebetterway.top` |
| **CNAME** | `www.artem` | `artem.thebetterway.top.` | 3600 | Редирект с www |

*(При использовании Cloudflare Pages или Vercel вместо A-записи указывается CNAME на выданный хостингом адрес, например `*.pages.dev` или `cname.vercel-dns.com`).*

---

## 🔒 Безопасность формы и Telegram Bot

В текущей версии заявки отправляются через Telegram Bot API прямо из браузера.
Для продакшена специалист может вынести токен бота в Cloudflare Worker или бекенд-обработчик (3-5 строк кода) и заменить `fetch` URL в функции `handleLeadSubmit` внутри `index.html`.
