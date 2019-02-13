import React from "react";
import Course from "../components/Course.js";

const ReactApp = ({props}) => {
  return (
    <div>
      <Course props={props} />
    </div>
  );
};

export default ReactApp;