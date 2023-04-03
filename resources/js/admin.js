require("./bootstrap");
import React from "react";
import { render } from "react-dom";
import Admin from './components/Admin/Admin';

export default function Test() {
  return (
    <Admin/>
  )
}


render(<Test />, document.getElementById('app'));