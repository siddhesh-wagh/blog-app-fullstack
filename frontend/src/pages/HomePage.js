import React from 'react';
import { Link } from 'react-router-dom';
import './HomePage.css';  // Import the new CSS file

function HomePage() {
  return (
    <div className="homepage-container">
      <h1>Welcome to the Blog App</h1>
      <p>Your go-to place for reading and sharing blogs.</p>

      <div className="blog-posts">
        {/* Mock Blog Posts */}
        <div className="post-card">
          <h3>Blog Post 1</h3>
          <p>Short description of the first blog post. This is just a preview!</p>
          <Link to="/post/1">Read More</Link>
        </div>
        <div className="post-card">
          <h3>Blog Post 2</h3>
          <p>Short description of the second blog post. This is just a preview!</p>
          <Link to="/post/2">Read More</Link>
        </div>
        <div className="post-card">
          <h3>Blog Post 3</h3>
          <p>Short description of the third blog post. This is just a preview!</p>
          <Link to="/post/3">Read More</Link>
        </div>
      </div>

      <div className="call-to-action">
        <h3>Join the Community</h3>
        <p>If you're new, you can create an account or log in.</p>
        <div>
          <button>
            <Link to="/login" className="link">Login</Link>
          </button>
          <button>
            <Link to="/register" className="link">Register</Link>
          </button>
        </div>
      </div>
    </div>
  );
}

export default HomePage;
