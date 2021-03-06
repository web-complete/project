# Web Complete Platform (WCP)

Web Complete Platform (WCP) — платформа для разработки веб-систем любой
сложности, разработанная согласно стандартам [PSR](https://en.wikipedia.org/wiki/PHP_Standard_Recommendation) и принципам проектирования [SOLID](https://en.wikipedia.org/wiki/SOLID_(object-oriented_design)).

WCP представляет собой набор независимых пакетов и модулей (кубов), а также встроенную CMS и позволяет:
1. быстро решать рутинные задачи 
2. вести качественную разработку на крупных и сложных проектах
3. использовать кубы в любом фреймворке, как вместе так и по отдельности, только необходимые.

WCP может быть использован как самостоятельный фреймворк для разработки проекта (так как имеет встроенную архитектуру MVC),
так и на базе любого фреймворка в качестве компонентной базы и CMS.

Основные пакеты* и кубы*: 
- **[core](https://github.com/web-complete/core)** (пакет) - представляет собой ядро для разработки доменной модели проекта (бизнес-логики) согласно методологии [Domain Driven Design (DDD)](https://en.wikipedia.org/wiki/Domain-driven_design)
- **[form](https://github.com/web-complete/form)** (пакет) - работа с формами, фильтрацией и валидацией пользовательского ввода
- **[rbac](https://github.com/web-complete/rbac)** (пакет) - система управления правами доступа
- **[mvc](https://github.com/web-complete/mvc)** (пакет) - инфраструктурная база
- **[admin](guide/admin/index.md)** (куб) - система управления контентом (CMS)

\* **Пакет (Package)** - это стандартная composer-библиотека.

\* **Куб (Cube)** - это внутренний модуль системы, представляющий собой совокупность классов и файлов, объединенные одним пространством имен. Функционал платформы позволяет легко и гибко интегрировать куб в систему.

##### Документация разработчика: [Оглавление](guide/index.md)