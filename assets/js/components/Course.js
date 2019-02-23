import React, { Component } from 'react'

class Course extends Component {
  constructor (props) {
    super(props)
    if(this.props.isLikedByUser){
      this.state = {
        isLiked: this.props.isLikedByUser,
        message: null
      }
    }
    else {
      this.state = {
        isLiked: false,
        message: null
      }
    }
    this.handleClick = this.handleClick.bind(this)
  }

  handleClick () {
    const isLiked = this.state.isLiked;
    this.setState({
      isLiked: !isLiked,
      message: isLiked ? "Favori retiré" : "Favori ajouté"
    })
    // we call serverside 
    fetch(this.props.base + '/cours/favorite/' + this.props.course.id)
    .then(function(response) {
      console.log(response);
    })
  }

  render () {
    return (
      <div className='card-course'>
        <p className="text-success">{this.state.message}</p>
        <div className='card-course__header'>
          <h1 className='card-course__header__title'>
            <span id='course-like' onClick={this.handleClick} title={this.state.isLiked ? 'Enlever des favoris' : 'Ajouter aux favoris'}>
              <i className={this.state.isLiked ? 'fas fa-star' : 'far fa-star'} />
            </span>&nbsp;
            {this.props.course.name}
          </h1>
          <button className='card-course__header__button' >{this.props.course.category}</button>
        </div>
        <div className='card__legend'>
        <p className='card-course__legend'>{this.props.course.description}</p>
        <button className="course__btn" title="Semestre">{this.props.course.semester}</button> 
        <button className="course__btn" title="Promotion">{this.props.course.promotion}</button> 
        <button className="course__btn course__btn--matiere" title="Département">Physique</button>
        </div>
      </div>
    )
  }
}

export default Course
