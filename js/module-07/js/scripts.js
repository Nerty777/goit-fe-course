"use strict";

let arr = [];

const posts = [
  {
    img: "https://placeimg.com/400/150/arch",
    title: "Post title 1",
    text:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, nemo dignissimos ea temporibus voluptatem maiores maxime consequatur impedit nobis sunt similique voluptas accusamus consequuntur, qui modi nesciunt veritatis distinctio rem!",
    link: "link-1.com"
  },
  {
    img: "https://placeimg.com/400/150/nature",
    title: "Post title 2",
    text:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, nemo dignissimos ea temporibus voluptatem maiores maxime consequatur impedit nobis sunt similique voluptas accusamus consequuntur, qui modi nesciunt veritatis distinctio rem!",
    link: "link-2.com"
  },
  {
    img: "https://placeimg.com/400/150/arch",
    title: "Post title 3",
    text:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, nemo dignissimos ea temporibus voluptatem maiores maxime consequatur impedit nobis sunt similique voluptas accusamus consequuntur, qui modi nesciunt veritatis distinctio rem!",
    link: "link-3.com"
  },
];

function createPostCard(post) {
  const card = document.createElement("div");
  card.classList.add("wrapper");

  const post_html = document.createElement("div");
  post_html.classList.add("post");

  const post_image = document.createElement("img");
  post_image.classList.add("post__image");
  post_image.setAttribute('src' , `${post.img}`);
  post_image.setAttribute( 'alt', "post image");

  const post_title = document.createElement("h2");
  post_title.classList.add("post__title");
  post_title.textContent = `${post.title}`;

  const post_text = document.createElement("p");
  post_text.classList.add("post__text");
  post_text.textContent = `${post.text}`;

  const button = document.createElement("a");
  button.classList.add("button");
  button.setAttribute('href', `${post.link}`);
  button.textContent = "Read more";

  post_html.append(post_image, post_title, post_text, button);
  card.append(post_html);

  return card.innerHTML;
}

function createCards(posts) {
  posts.map(post => {
    arr.push(createPostCard(post));
    return arr;
  });
}

createCards(posts);

const cards = document.querySelector(".wrapper");

cards.insertAdjacentHTML("afterbegin", arr.join(""));
