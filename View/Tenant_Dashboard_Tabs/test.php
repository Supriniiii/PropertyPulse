<!DOCTYPE html>
<html>
<head>
  <title>Simplified Star Rating</title>
  <style>
    .rating {
      unicode-bidi: bidi-override;
      direction: rtl;
    }
    .rating input[type="radio"] { 
      position: absolute;
      left: -9999px; 
    }
    .rating label { 
      display: inline-block; 
      width: 1em;
      height: 1em;
      overflow: hidden;
      text-indent: -9999px; 
      cursor: pointer;
    }
    .rating label svg {
      fill: #ccc; 
      transition: fill 0.3s; 
    }
    .rating label:hover svg,
    .rating label:hover ~ label svg,
    .rating input[type="radio"]:checked ~ label svg { 
      fill: url(#star-grad); 
    }
  </style>
</head>
<body>
  <div class="rating">
    <input type="radio" name="star" id="star5" value="5">
    <label for="star5" title="5 stars">
      <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
    </label>
    <input type="radio" name="star" id="star4" value="4">
    <label for="star4" title="4 stars"><svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></label>
    <input type="radio" name="star" id="star3" value="3">
    <label for="star3" title="3 stars"><svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></label>
    <input type="radio" name="star" id="star2" value="2">
    <label for="star2" title="2 stars"><svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></label>
    <input type="radio" name="star" id="star1" value="1">
    <label for="star1" title="1 star"><svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></label>
  </div>

  <svg >
    <defs>
      <linearGradient id="star-grad" x1="50%" y1="5.4%" x2="87.6%" y2="65.5%">
        <stop offset="0%" stop-color="#f0ad4e"></stop>
        <stop offset="60%" stop-color="#f0ad4e"></stop>
        <stop offset="100%" stop-color="#d9534f"></stop>
      </linearGradient>
    </defs>
  </svg>
</body>
</html>
