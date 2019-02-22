import React from 'react';
import CourseWidget from '../components/Course';
import { Helmet } from 'react-helmet';

export default class Course extends React.Component {
  constructor (props, context) {
    super(props, context)

    // We check if there is no course (only client side)
    // Or our id doesn't match the course that we received server-side
    
    if ( !this.props.course ) {
      this.state = {
        course: null,
        loading: true
      }
    } else {
      this.state = {
        course: this.props.course,
        loading: false
      }
    }
  }

  componentDidMount () {
    if (this.state.loading) {
      fetch(this.props.base + '/api/courses/' + this.props.course.id)
        .then(response => response.json())
        .then(data => {
          this.setState({
            course: data,
            loading: false
          })
        })
    }
  }

  render () {
    if (this.state.loading) {
      console.log( this.props.base);
      return <div>Chargement du cours ... </div>
    } else {
      return (
        <div>
          <Helmet>
            <title>Absinthe - {this.state.course.name}</title>
          </Helmet>
          <CourseWidget course={this.state.course} />
        </div>
      )
    }
  }
}
