import "./App.css";
import React from "react";

function App(props) {
  return (
    <div>
      <div className="flex flex-row flex-wrap gap-4">
        <pre className="basis-1/4">{props.snake}</pre>
      </div>
    </div>
  );
}
export default App;
