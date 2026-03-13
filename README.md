# Pair Programming Exercise

## Overview

This is a **60-minute live pair-programming exercise** over screen share. You'll be working with legacy PHP code — an inventory management system for a fantasy inn. The code works, but it's messy, untyped, and hard to extend.

Your job is to **refactor and extend** it. We're interested in how you think and communicate as much as the code you write. Talk through your decisions as you go.

You are welcome to use AI assistants (Copilot, Claude, etc.) during this exercise — that reflects how we work day to day.

## Getting Started

```
composer install
composer test
```

All existing tests should pass before you begin making changes.

## The Inventory System

We are a small inn with a prime location in a prominent city ran by a friendly innkeeper named Allison. We buy and sell only the finest goods.

Our goods degrade in quality as they approach their sell-by date. The system updates inventory at the end of each day:

- All items have a **SellIn** value (days remaining to sell) and a **Quality** value (how valuable the item is)
- At the end of each day, both values decrease for every item

The rules:

- Once the sell-by date has passed, **Quality degrades twice as fast**
- Quality is never negative
- **Aged Brie** increases in Quality the older it gets
- Quality is never more than 50
- **Sulfuras** is legendary — it never has to be sold and never decreases in Quality (its Quality is always 80)
- **Backstage passes** increase in Quality as the concert approaches: +2 when 10 days or less, +3 when 5 days or less, but drops to 0 after the concert

---

## The Task

The `nextDay()` method in `GildedRose.php` is deeply nested spaghetti. Refactor it into clean, extensible object-oriented code, then implement two new item types.

Feel free to make any changes to the `nextDay` method and add any new code as long as everything still works correctly. However, **do not alter the `Item` class or `items` property** as those belong to the goblin in the corner who will insta-rage you as he doesn't believe in shared code ownership.

### Requirements

- Refactor `nextDay()` so each item type's behaviour is encapsulated (Strategy pattern, polymorphism, or similar)
- Adding a new item type in future should not require modifying existing code (Open/Closed Principle)
- All existing tests must continue to pass
- Uncomment the **Conjured** item tests and make them pass:
  - Conjured items degrade in Quality twice as fast as normal items
- Implement a new **Enchanted** item type and write tests for it:
  - Enchanted items increase in Quality by 2 each day (twice as fast as Aged Brie)
  - After the sell-by date, Quality still increases but only by 1
  - If Quality reaches exactly 50, it resets to 0 on the next day
- Write any additional tests you think are missing

---

## Bonus

Expose the inventory system as a simple REST API. No framework required — PHP's built-in server is fine.

We follow a layered architecture across our services:

```
Controller → Service (via interface) → Repository (via interface) → Model
```

- **Controller** — handles HTTP concerns only (request in, response out)
- **Service** — business logic and orchestration, injected via an interface
- **Repository** — data access, injected via an interface
- **Model** — your `Item` class (already exists)

Each layer should depend on the interface of the layer below it, not the concrete implementation.

Endpoints to implement:

- `GET /items` — list all items as JSON
- `GET /items/{name}` — fetch a single item by name (return 404 if not found)
- `POST /items/advance-day` — advance all items by one day and return updated state
- Proper HTTP status codes and error responses as JSON
