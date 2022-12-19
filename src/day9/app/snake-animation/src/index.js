import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import App from "./App";
import reportWebVitals from "./reportWebVitals";

const root = ReactDOM.createRoot(document.getElementById("root"));

let counter = 1;

async function getData(counter) {
  const [res8] = await Promise.all([
    fetch(process.env.PUBLIC_URL + "/maps/2/" + counter + "-tail.txt"),
  ]);

  const snake9 = await res8.text();

  return [snake9];
}

function tick() {
  getData(counter).then(([snake9]) => {
    root.render(
      <React.StrictMode>
        <App counter={counter} snake={snake9} />
      </React.StrictMode>
    );
  });
  if (counter == 11650) {
    counter = 0;
  } else {
    counter++;
  }
}
setInterval(tick, 100);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals(console.log);
