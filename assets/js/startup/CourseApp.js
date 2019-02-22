import React from 'react';
import Courses from '../containers/Courses';
import Course from '../components/Course';
import { Route } from 'react-router-dom';

const CoursesApp = ({ initialProps, appContext }) => {
  return (
    <div>
      <Route
        exact path={'/cours'}
        render={props => (
          <Courses {...initialProps} base={appContext.base} {...props} />
        )}
      />
      <Route
        path={'/cours/:id'}
        render={props => (
          <Course {...initialProps} base={appContext.base} {...props} />
        )}
      />
    </div>
  )
}

export default CoursesApp
