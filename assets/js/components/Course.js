import React from 'react';

const Course = props => {
  return (
    <div className='card-course'>
      <div className='card-course__header'>
        <h1 className='card-course__header__title'><span id="course-like"><i class="far fa-star"></i></span>&nbsp;{ props.course.name }</h1>
        <button className='card-course__header__button'>{ props.course.category }</button>
      </div>
      <p className="card-course__legend">{ props.course.description }</p>
    </div>
  )
}

export default Course
