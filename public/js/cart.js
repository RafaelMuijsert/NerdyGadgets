const addToCart = (article) => {
  let cart = JSON.parse(window.localStorage.getItem('cart')) || [];
  cart.push(article);
  window.localStorage.setItem('cart', JSON.stringify(cart));
} 
