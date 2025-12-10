# YouTube Video Info Laravel App

A small Laravel application that accepts a YouTube video ID, fetches information from the YouTube Data API (v3), and returns a custom structured JSON output.

## Table of contents

- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Environment](#environment)
- [Running the app](#running-the-app)
- [Usage](#usage)
- [Example output](#example-output)

## Features

- Accepts a YouTube video ID via a simple form
- Uses the YouTube Data API v3 to fetch video metadata
- Transforms and exposes a custom JSON structure

## Prerequisites

- PHP 8.1+
- Composer
- Laravel 9+
- A valid YouTube API Key (v3) — free up to 10,000 requests/day
- Node / npm (optional, for frontend assets)

## Installation

1. Clone the repository

   git clone https://github.com/MrBitFish/Youtube-video-processor.git

2. Install PHP dependencies

   composer install

## Environment

Copy the example environment file and update the values:

cp .env.example .env

Edit ` .env ` and add your YouTube API key:

YOUTUBE_API_KEY=YOUR_YOUTUBE_API_KEY

Generate the application key:

php artisan key:generate


## Running the app

Start the Laravel development server:

php artisan serve

Open your browser and navigate to:

http://127.0.0.1:8000

You should see the YouTube Video Lookup form. Enter a YouTube video ID and submit to view the transformed JSON output.

## Usage

- Use the web form at the root URL to lookup a video by ID.
- The app will call the YouTube Data API and return a custom JSON response.

## Example output

A simplified example of the transformed JSON returned by the app:

```json
{
  "id": "dQw4w9WgXcQ",
  "title": "Example Video Title",
  "description": "Video description text...",
  "channel": {
    "id": "UCxxxx",
    "title": "Channel Name"
  },
  "statistics": {
    "views": 12345,
    "likes": 678,
    "comments": 90
  },
  "published_at": "2020-01-01T00:00:00Z"
}
