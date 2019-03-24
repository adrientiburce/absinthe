import React, { Component } from 'react';
import { Route } from 'react-router-dom';
import Courses from '../containers/Courses';
import Course from '../containers/Course';

class CourseApp extends Component {
  constructor(initialProps, appContext) {
    super(initialProps, appContext);
  }
  render() {
    if (this.props.initialProps.category == undefined) {
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
      </div>
    )
    }
    else{
      return(
        <div>
        <Route
          path="/cours/:id"
          render={props => (
            <Course {...this.props.initialProps} base={this.props.appContext.base} {...props} />
          )}
        />
        <Route
            path={`/categorie/${this.props.initialProps.category[0]["slug"]}`}
            exact
            render={props => (
              <Courses {...this.props.initialProps} base={this.props.appContext.base} {...props} title={this.props.initialProps.category[0]["name"]}/>
            )}
          />
        </div>
      )
      }
  }
}

export default CourseApp;
