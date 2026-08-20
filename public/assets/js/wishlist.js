/**
 * Wishlist — client-side, persisted in localStorage.
 * Works across every page: header badges, product-card heart buttons,
 * and the dedicated /wishlist page all read/write the same store.
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'wishlist_items';
  var toastEl = null;
  var toastTimer = null;

  function getItems() {
    try {
      var raw = window.localStorage.getItem(STORAGE_KEY);
      var items = raw ? JSON.parse(raw) : [];
      return Array.isArray(items) ? items : [];
    } catch (e) {
      return [];
    }
  }

  function saveItems(items) {
    try {
      window.localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    } catch (e) {
      /* storage unavailable (private mode / quota) — fail silently */
    }
    refreshUI();
  }

  function slugify(text) {
    return (text || '')
      .toString()
      .trim()
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '') || 'item-' + Date.now();
  }

  function isInWishlist(id) {
    return getItems().some(function (item) { return item.id === id; });
  }

  function addItem(item) {
    var items = getItems();
    if (items.some(function (i) { return i.id === item.id; })) return;
    items.push(item);
    saveItems(items);
  }

  function removeItem(id) {
    var items = getItems().filter(function (i) { return i.id !== id; });
    saveItems(items);
  }

  function toggleItem(item) {
    if (isInWishlist(item.id)) {
      removeItem(item.id);
      return false;
    }
    addItem(item);
    return true;
  }

  function updateCountBadges() {
    var count = getItems().length;
    document.querySelectorAll('.js-wishlist-count').forEach(function (el) {
      el.textContent = String(count);
    });
  }

  function updateButtonStates() {
    document.querySelectorAll('.js-add-wishlist').forEach(function (btn) {
      var item = extractItemFromButton(btn);
      var active = !!(item && isInWishlist(item.id));
      btn.classList.toggle('active', active);
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
      btn.setAttribute('title', active ? 'Remove From Wishlist' : 'Add To Wishlist');
    });
  }

  function extractItemFromButton(btn) {
    var card = btn.closest('.product-card');
    if (!card) return null;

    var titleEl = card.querySelector('.pc__title');
    var title = titleEl ? titleEl.textContent.trim() : '';
    if (!title) return null;

    var priceEl = card.querySelector('.product-card__price .price');
    var price = priceEl ? priceEl.textContent.trim() : '';

    var imgEl = card.querySelector('.pc__img');
    var image = imgEl ? imgEl.getAttribute('src') : '';

    var linkEl = card.querySelector('.pc__title a') || card.querySelector('.pc__img-wrapper a');
    var href = linkEl ? linkEl.getAttribute('href') : '#';

    return {
      id: slugify(title),
      title: title,
      price: price,
      image: image,
      href: href || '#'
    };
  }

  function ensureToast() {
    if (toastEl) return toastEl;
    toastEl = document.createElement('div');
    toastEl.className = 'wishlist-toast';
    toastEl.setAttribute('role', 'status');
    toastEl.setAttribute('aria-live', 'polite');
    toastEl.innerHTML =
      '<svg class="wishlist-toast__icon" width="18" height="18" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>' +
      '<span class="wishlist-toast__text"></span>';
    document.body.appendChild(toastEl);
    return toastEl;
  }

  function showToast(message) {
    var el = ensureToast();
    el.querySelector('.wishlist-toast__text').textContent = message;
    el.classList.add('is-visible');
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(function () {
      el.classList.remove('is-visible');
    }, 2400);
  }

  function renderWishlistPage() {
    var listEl = document.querySelector('[data-wishlist-list]');
    var emptyEl = document.querySelector('[data-wishlist-empty]');
    var template = document.getElementById('wishlist-item-template');
    if (!listEl || !template) return;

    var items = getItems();
    listEl.innerHTML = '';

    if (items.length === 0) {
      if (emptyEl) emptyEl.classList.remove('d-none');
      listEl.classList.add('d-none');
      return;
    }

    if (emptyEl) emptyEl.classList.add('d-none');
    listEl.classList.remove('d-none');

    items.forEach(function (item) {
      var node = template.content.cloneNode(true);

      node.querySelectorAll('[data-wishlist-href]').forEach(function (a) {
        a.setAttribute('href', item.href || '#');
      });

      var img = node.querySelector('[data-wishlist-image]');
      if (img) {
        img.setAttribute('src', item.image || '');
        img.setAttribute('alt', item.title || '');
      }

      var titleEl = node.querySelector('[data-wishlist-title]');
      if (titleEl) titleEl.textContent = item.title;

      var priceEl = node.querySelector('[data-wishlist-price]');
      if (priceEl) priceEl.textContent = item.price || '';

      var removeBtn = node.querySelector('[data-wishlist-remove]');
      if (removeBtn) {
        removeBtn.addEventListener('click', function () {
          removeItem(item.id);
          showToast('Removed "' + item.title + '" from your wishlist');
        });
      }

      listEl.appendChild(node);
    });
  }

  function refreshUI() {
    updateCountBadges();
    updateButtonStates();
    renderWishlistPage();
  }

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.js-add-wishlist');
    if (!btn) return;
    e.preventDefault();

    var item = extractItemFromButton(btn);
    if (!item) return;

    var added = toggleItem(item);
    showToast(added
      ? 'Added "' + item.title + '" to your wishlist'
      : 'Removed "' + item.title + '" from your wishlist');
  });

  window.addEventListener('storage', function (e) {
    if (e.key === STORAGE_KEY) refreshUI();
  });

  document.addEventListener('DOMContentLoaded', refreshUI);
})();
