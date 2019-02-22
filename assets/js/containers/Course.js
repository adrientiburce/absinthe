import React from 'react';
import CourseWidget from '../components/Course';
import { Helmet } from 'react-helmet';

export default class Course extends React.Component {
  constructor (props, context) {
    super(props, context)

    // We check if there is no course (only client side)
    // Or our id doesn't match the course that we received server-side
    
    if ( !this.props.course || (this.props.match.params.id && this.props.match.params.id != this.props.course.id) ) {
      this.state = {
        course: null,
        loading: true
      }
    } else {
      this.state = {
        course: this.props.course,
        isLikedByUser: this.props.isLikedByUser,
        loading: false
      }
    }
  }

  componentDidMount () {
    if (this.state.loading) {
      fetch(this.props.base + '/api/cours/' + this.props.course.id)
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
      return <div>Chargement du cours ... </div>
    } else {
      return (
        <div>
          <Helmet>
            <title>{this.state.course.name}</title>
          </Helmet>
          <CourseWidget course={this.state.course} isLikedByUser={this.state.isLikedByUser} base={this.props.base} />
        </div>
      )
    }
  }
}
