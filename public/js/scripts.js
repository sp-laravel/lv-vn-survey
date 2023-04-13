// Div
let btnUpddate = document.querySelector("#btnUpddate");
let update = document.querySelector(".update");
let loading = document.querySelector(".loading");

// Refresh Web
btnUpddate.addEventListener("click", function() {
  handleHardReload(url)
});

// Force Clean Cache
async function handleHardReload(url) {
  await fetch(url, {
    headers: {
      Pragma: 'no-cache',
      Expires: '-1',
      'Cache-Control': 'no-cache',
    },
  });
  window.location.href = url;
  window.location.reload();
}

update.addEventListener('click', function (e) {
  loading.classList.add("loading--active");
  // console.log("update");
})