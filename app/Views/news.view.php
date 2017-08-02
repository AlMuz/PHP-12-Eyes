{% set name = 'All News' %}

{% include 'header.php' %}

<a href="/news/add">Add A New</a>

<ul>
    {% for new in news %}
    <li><a href="/news/{{new.news_id}}">{{ new.title }}</a> |
        <small><i>{{ new.author }} | {{ new.created_at|time_diff }}</i></small>
    </li>

    <p>{{ new.body|length > 200 ? new.body|slice(0, 200) ~ '...' : new.body }}</p>
    {% endfor %}
</ul>

{% include 'footer.php' %}
