import React, { Component } from 'react'

class Course extends Component {
  constructor (props) {
    super(props)
    if(this.props.isLikedByUser){
      this.state = {
        isLiked: this.props.isLikedByUser
      }
    }
    else {
      this.state = {
        isLiked: false
      }
    }
    this.handleClick = this.handleClick.bind(this)
  }

  handleClick () {
    // we change favorite icon 
    const isLiked = this.state.isLiked;
    this.setState({
      isLiked: !isLiked
    })
    // we call serverside 
    //window.location.href = this.props.base + '/cours/favorite/' + this.props.course.id;
    fetch(this.props.base + '/cours/favorite/' + this.props.course.id)
      .then(response => {
        console.log(response);
      })
  }

  render () {
    return (
      <div className='card-course'>
        <div className='card-course__header'>
          <h1 className='card-course__header__title'>
            <span id='course-like' onClick={this.handleClick} title={this.state.isLiked ? 'Enlever des favoris' : 'Ajouter aux favoris'}>
              <i className={this.state.isLiked ? 'fas fa-star' : 'far fa-star'} />
            </span>&nbsp;
            {this.props.course.name}
          </h1>
          <button className='card-course__header__button' >{this.props.course.category}</button>
        </div>
        <p className='card-course__legend'>{this.props.course.description}</p>
      </div>
    )
  }
}

export default Course
