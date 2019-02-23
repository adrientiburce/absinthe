import React, { Component } from 'react'
import Courses from "../containers/Courses";
import Course from "../containers/Course";
import { Route } from "react-router-dom";

class CourseApp extends Component  {
  constructor(initialProps, appContext){
    super(initialProps, appContext)
  }
  render(){
    const routes_courses = ['/cours-tronc-commun','/cours-integration','/cours-disciplinaires'];

    return (
      <div>
        <Route
          path={'/cours/:id'}
          render={props => (
            <Course {...this.props.initialProps} base={this.props.appContext.base} {...props} />
          )}
        />
        {routes_courses.map((route, idx) => (
          <Route
          key={idx}
          path={route}
          exact
          render={props => (
            <Courses {...this.props.initialProps} base={this.props.appContext.base} {...props} />
          )}
        />
        ))
        }
      </div>
    );
  }
};

export default CourseApp;
