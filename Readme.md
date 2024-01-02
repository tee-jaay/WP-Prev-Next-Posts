**Plugin Name:** Prev_Next_Posts

**Description:** This plugin provides an endpoint for retrieving the previous and next posts' information for a given post.

**Version:** 0.1

**Author:** Tam Jid

**Author URI:** https://github.com/tee-jaay

**Features:**

- Retrieves the previous and next posts for a given post ID.
- Uses custom REST API endpoint for easy integration.

**Installation:**

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the WordPress admin panel.

**Usage:**

To use the plugin, send a GET request to the following endpoint:

```
https://your-website.com/wp-json/custom/v1/posts/<post_id>/prev-next
```

Replace `<post_id>` with the ID of the post for which you want to retrieve the previous and next posts.

The response will be a JSON object containing the following information:

```
{
  "previous": {
    "title": "Previous Post Title",
    "slug": "previous-post-slug"
  },
  "next": {
    "title": "Next Post Title",
    "slug": "next-post-slug"
  }
}
```

You can use this information to display the previous and next posts on your website.

**Customization:**

You can customize the plugin by modifying the `custom_get_prev_next_posts` function in the plugin file.

For example, you can change the number of posts to retrieve, the order of the posts.

**Support:**

If you have any questions or need assistance with the plugin, please feel free to contact the author.