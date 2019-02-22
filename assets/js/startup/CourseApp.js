import React from "react";
import Courses from "../containers/Courses";
import Course from "../containers/Course";
import { Route } from "react-router-dom";

const CoursesApp = ({ initialProps, appContext }) => {
  return (
    <div>
      <Route
        path={'/cours/:id'}
        render={props => (
          <Course {...initialProps} base={appContext.base} {...props} />
        )}
      />
      <Route
        path={'/cours'}
        exact
        render={props => (
          <Courses  {...initialProps} base={appContext.base} {...props} />
        )}
      />
    </div>
  );
};

export default CoursesApp;
