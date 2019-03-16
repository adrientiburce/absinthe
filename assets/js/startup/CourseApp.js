import React, { Component } from 'react';
import { Route } from 'react-router-dom';
import Courses from '../containers/Courses';
import Course from '../containers/Course';

class CourseApp extends Component {
  constructor(initialProps, appContext) {
    super(initialProps, appContext);
  }

  render() {
    const routes_courses = ['/cours-tronc-commun', '/cours-integration', '/cours-disciplinaires'];
    const title_courses = ['Tronc Commun', 'Cours Integration', 'Cours Disciplinaires'];
    return (
      <div>
        <Route
          path="/cours/:id"
          render={props => (
            <Course {...this.props.initialProps} base={this.props.appContext.base} {...props} />
          )}
        />
         <Route
          path="/cours-favoris"
          render={props => (
            <Courses {...this.props.initialProps} base={this.props.appContext.base} {...props}  title="Mes Cours Favoris"/>
          )}
        />
        {routes_courses.map((route, idx) => (
          <Route
            key={idx}
            path={route}
            exact
            render={props => (
              <Courses {...this.props.initialProps} base={this.props.appContext.base} {...props} title={title_courses[idx]}/>
            )}
          />
        ))
        }
      </div>
    );
  }
}

export default CourseApp;
