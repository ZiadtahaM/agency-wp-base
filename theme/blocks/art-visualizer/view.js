document.addEventListener('DOMContentLoaded', () => {
  const visualizers = document.querySelectorAll('[data-component="art-visualizer"]');

  visualizers.forEach(vis => {
    const frameEl = vis.querySelector('[data-frame-element]');
    const priceDisplay = vis.querySelector('[data-price-display]');
    const sizeBtns = vis.querySelectorAll('[data-size-selector] button');
    const frameBtns = vis.querySelectorAll('[data-frame-selector] button');

    // Handle Frame Change
    frameBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        frameBtns.forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        const frameType = btn.dataset.frame;
        frameEl.className = 'art-visualizer__frame art-visualizer__frame--' + frameType;
      });
    });

    // Handle Size & Price Change
    sizeBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        sizeBtns.forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        const price = btn.dataset.price;
        if (priceDisplay && price) {
          priceDisplay.textContent = price;
        }

        const size = btn.dataset.size;
        if (size === '40x60') frameEl.style.transform = 'scale(0.85)';
        if (size === '60x90') frameEl.style.transform = 'scale(1)';
        if (size === '80x120') frameEl.style.transform = 'scale(1.12)';
        if (size === '100x150') frameEl.style.transform = 'scale(1.22)';
      });
    });
  });
});
