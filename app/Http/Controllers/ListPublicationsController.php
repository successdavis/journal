<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ListPublicationsController extends Controller
{
    public function latestThesis()
    {
        return response()->json([
            'categories' => ['Education', 'Science', 'Engineering', 'Technology', 'Mathematics', 'Health'],
            'publications' => [
                ['author' => 'Jane Doe', 'title' => 'AI in Education', 'image' => '/images/ai.jpg', 'excerpt' => 'An insightful overview of machine learning in classrooms...', 'category' => 'Education'],
                ['author' => 'John Smith', 'title' => 'Quantum Physics Explained', 'image' => '/images/quantum.jpg', 'excerpt' => 'Demystifying the principles of quantum mechanics...', 'category' => 'Science'],
                ['author' => 'Emily Turner', 'title' => 'Renewable Energy Engineering', 'image' => '/images/renewable.jpg', 'excerpt' => 'Exploring innovations in renewable energy systems...', 'category' => 'Engineering'],
                ['author' => 'Michael White', 'title' => 'The Rise of Smart Technology', 'image' => '/images/smart-tech.jpg', 'excerpt' => 'A deep dive into IoT and smart devices...', 'category' => 'Technology'],
                ['author' => 'Laura Kim', 'title' => 'Algebraic Structures Simplified', 'image' => '/images/math.jpg', 'excerpt' => 'Understanding groups, rings, and fields in mathematics...', 'category' => 'Mathematics'],
                ['author' => 'Dr. Alan Price', 'title' => 'Nutrition in the 21st Century', 'image' => '/images/health.jpg', 'excerpt' => 'A modern look at diet and nutrition science...', 'category' => 'Health'],

                // More publications (44 more to follow for a total of 50)
                ['author' => 'Sara Lane', 'title' => 'Virtual Classrooms', 'image' => '/images/edu1.jpg', 'excerpt' => 'The digital transformation of education...', 'category' => 'Education'],
                ['author' => 'Neil Grant', 'title' => 'Exploring the Cosmos', 'image' => '/images/science1.jpg', 'excerpt' => 'Latest discoveries in astrophysics...', 'category' => 'Science'],
                ['author' => 'Rita Zheng', 'title' => 'Civil Engineering Today', 'image' => '/images/eng1.jpg', 'excerpt' => 'Modern approaches to infrastructure development...', 'category' => 'Engineering'],
                ['author' => 'Omar Khadir', 'title' => '5G Networks and Beyond', 'image' => '/images/tech1.jpg', 'excerpt' => 'What the future of mobile networks holds...', 'category' => 'Technology'],
                ['author' => 'Jasmine Patel', 'title' => 'Calculus in Real Life', 'image' => '/images/math1.jpg', 'excerpt' => 'Applications of calculus in various industries...', 'category' => 'Mathematics'],
                ['author' => 'Dr. Helen Stone', 'title' => 'Mental Health Matters', 'image' => '/images/health1.jpg', 'excerpt' => 'Raising awareness about mental wellness...', 'category' => 'Health'],
                ['author' => 'Tom Richards', 'title' => 'Blended Learning Strategies', 'image' => '/images/edu2.jpg', 'excerpt' => 'Combining online and offline education models...', 'category' => 'Education'],
                ['author' => 'Linda Gomez', 'title' => 'Genetic Engineering Explained', 'image' => '/images/science2.jpg', 'excerpt' => 'The ethical and scientific sides of gene editing...', 'category' => 'Science'],
                ['author' => 'Raj Mehta', 'title' => 'Mechanical Design Innovations', 'image' => '/images/eng2.jpg', 'excerpt' => 'The evolution of mechanical systems and tools...', 'category' => 'Engineering'],
                ['author' => 'Nancy Wu', 'title' => 'Augmented Reality Tech', 'image' => '/images/tech2.jpg', 'excerpt' => 'AR’s impact across industries...', 'category' => 'Technology'],
                ['author' => 'Victor Nunez', 'title' => 'Statistics for Data Science', 'image' => '/images/math2.jpg', 'excerpt' => 'Statistical tools for modern data analysis...', 'category' => 'Mathematics'],
                ['author' => 'Dr. Olivia Ross', 'title' => 'Preventive Healthcare', 'image' => '/images/health2.jpg', 'excerpt' => 'Building a proactive health regime...', 'category' => 'Health'],
                ['author' => 'Amanda Li', 'title' => 'E-learning Platforms Compared', 'image' => '/images/edu3.jpg', 'excerpt' => 'Which platform leads in digital learning?', 'category' => 'Education'],
                ['author' => 'Greg Howard', 'title' => 'Climate Change Indicators', 'image' => '/images/science3.jpg', 'excerpt' => 'Tracking global warming metrics...', 'category' => 'Science'],
                ['author' => 'Kevin Brooks', 'title' => 'Smart Cities Infrastructure', 'image' => '/images/eng3.jpg', 'excerpt' => 'Designing efficient urban areas...', 'category' => 'Engineering'],
                ['author' => 'Anita Sharma', 'title' => 'Cybersecurity Essentials', 'image' => '/images/tech3.jpg', 'excerpt' => 'Protecting data in the digital age...', 'category' => 'Technology'],
                ['author' => 'Brian O’Neil', 'title' => 'Geometry in Architecture', 'image' => '/images/math3.jpg', 'excerpt' => 'The art and science of geometric design...', 'category' => 'Mathematics'],
                ['author' => 'Dr. Carla Bane', 'title' => 'Cardiovascular Advances', 'image' => '/images/health3.jpg', 'excerpt' => 'New treatments for heart disease...', 'category' => 'Health'],

                // Repeat similar entries to reach 50
                ['author' => 'Leo Chang', 'title' => 'Online Learning Behaviors', 'image' => '/images/edu4.jpg', 'excerpt' => 'What drives digital learners?', 'category' => 'Education'],
                ['author' => 'Elaine Ford', 'title' => 'Space-Time Theories', 'image' => '/images/science4.jpg', 'excerpt' => 'Modern takes on Einstein’s theories...', 'category' => 'Science'],
                ['author' => 'Peter Shaw', 'title' => 'Sustainable Architecture', 'image' => '/images/eng4.jpg', 'excerpt' => 'Building designs for the future...', 'category' => 'Engineering'],
                ['author' => 'Tamara Knox', 'title' => 'Wearable Technology Trends', 'image' => '/images/tech4.jpg', 'excerpt' => 'Fitness bands to smart glasses...', 'category' => 'Technology'],
                ['author' => 'Andrew Li', 'title' => 'Discrete Math Principles', 'image' => '/images/math4.jpg', 'excerpt' => 'How discrete mathematics powers computer science...', 'category' => 'Mathematics'],
                ['author' => 'Dr. Susan Lee', 'title' => 'Global Health Crises', 'image' => '/images/health4.jpg', 'excerpt' => 'Epidemics and health systems response...', 'category' => 'Health'],

                // Add more authors and shuffle categories
                ['author' => 'James Walker', 'title' => 'Adaptive Learning Models', 'image' => '/images/edu5.jpg', 'excerpt' => 'Personalized learning paths through AI...', 'category' => 'Education'],
                ['author' => 'Felix Tan', 'title' => 'Nuclear Energy Prospects', 'image' => '/images/science5.jpg', 'excerpt' => 'Reevaluating nuclear power...', 'category' => 'Science'],
                ['author' => 'Jessica Ray', 'title' => 'Robotics in Engineering', 'image' => '/images/eng5.jpg', 'excerpt' => 'How robots are transforming factories...', 'category' => 'Engineering'],
                ['author' => 'Maya Carson', 'title' => 'Tech Ethics Today', 'image' => '/images/tech5.jpg', 'excerpt' => 'Privacy, AI, and moral design...', 'category' => 'Technology'],
                ['author' => 'Noah Blake', 'title' => 'Linear Algebra Use Cases', 'image' => '/images/math5.jpg', 'excerpt' => 'Real-world uses of matrices and vectors...', 'category' => 'Mathematics'],
                ['author' => 'Dr. Leo Singh', 'title' => 'Immunology Breakthroughs', 'image' => '/images/health5.jpg', 'excerpt' => 'New vaccines and therapies...', 'category' => 'Health'],
            ]
        ]);

    }

}
