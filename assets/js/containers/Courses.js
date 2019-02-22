import React, { Component } from 'react';
import CourseList from '../components/CourseList';
import { Helmet } from 'react-helmet';

export default class Courses extends React.Component {
  constructor (props, context) {
    super(props, context)
    if (this.props.courses) {
      this.state = {
        courses: this.props.courses,
        loading: false,
        count: 0
      }
    } else {
      this.state = {
        courses: null,
        loading: true,
        count: 0
      }
    }
  }

  componentDidMount () {
    if (this.state.loading) {
      fetch(this.props.base + '/api/courses')
        .then(response => {
          return response.json()
        })
        .then(data => {
          this.setState({
            courses: data,
            loading: false
          })
        })
    }
  }
  render () {

    

    if (this.state.loading) {
      // console.log( this.props.base, data);
      return <div>Chargement ...</div>
    } else {
      console.log(this.context);
      return (
        <div>
          <Helmet>
            <title>Absinthe </title>
          </Helmet>
          <CourseList
            courses={this.state.courses}
            routePrefix={this.props.base}
          />
        </div>
      )
    }
  }
}
