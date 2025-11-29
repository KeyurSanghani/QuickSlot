<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>QuickSlot API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.5.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.5.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-contact-merge" class="tocify-header">
                <li class="tocify-item level-1" data-unique="contact-merge">
                    <a href="#contact-merge">Contact Merge</a>
                </li>
                                    <ul id="tocify-subheader-contact-merge" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="contact-merge-POSTapi-v1-contacts-merge-preview">
                                <a href="#contact-merge-POSTapi-v1-contacts-merge-preview">Preview merge</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="contact-merge-POSTapi-v1-contacts-merge-execute">
                                <a href="#contact-merge-POSTapi-v1-contacts-merge-execute">Execute merge</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-contacts" class="tocify-header">
                <li class="tocify-item level-1" data-unique="contacts">
                    <a href="#contacts">Contacts</a>
                </li>
                                    <ul id="tocify-subheader-contacts" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="contacts-GETapi-v1-contacts">
                                <a href="#contacts-GETapi-v1-contacts">List contacts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="contacts-POSTapi-v1-contacts">
                                <a href="#contacts-POSTapi-v1-contacts">Create a contact</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="contacts-GETapi-v1-contacts--id-">
                                <a href="#contacts-GETapi-v1-contacts--id-">Get a contact</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="contacts-PUTapi-v1-contacts--id-">
                                <a href="#contacts-PUTapi-v1-contacts--id-">Update a contact</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="contacts-DELETEapi-v1-contacts--id-">
                                <a href="#contacts-DELETEapi-v1-contacts--id-">Delete a contact</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="contacts-PATCHapi-v1-contacts--contact--restore">
                                <a href="#contacts-PATCHapi-v1-contacts--contact--restore">Restore a contact</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-custom-field-definitions" class="tocify-header">
                <li class="tocify-item level-1" data-unique="custom-field-definitions">
                    <a href="#custom-field-definitions">Custom Field Definitions</a>
                </li>
                                    <ul id="tocify-subheader-custom-field-definitions" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="custom-field-definitions-GETapi-v1-custom-field-definitions">
                                <a href="#custom-field-definitions-GETapi-v1-custom-field-definitions">List custom field definitions</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="custom-field-definitions-POSTapi-v1-custom-field-definitions">
                                <a href="#custom-field-definitions-POSTapi-v1-custom-field-definitions">Create a custom field definition</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="custom-field-definitions-GETapi-v1-custom-field-definitions--id-">
                                <a href="#custom-field-definitions-GETapi-v1-custom-field-definitions--id-">Get a custom field definition</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="custom-field-definitions-PUTapi-v1-custom-field-definitions--id-">
                                <a href="#custom-field-definitions-PUTapi-v1-custom-field-definitions--id-">Update a custom field definition</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="custom-field-definitions-DELETEapi-v1-custom-field-definitions--id-">
                                <a href="#custom-field-definitions-DELETEapi-v1-custom-field-definitions--id-">Delete a custom field definition</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="custom-field-definitions-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status">
                                <a href="#custom-field-definitions-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status">Update status of a custom field definition</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="custom-field-definitions-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore">
                                <a href="#custom-field-definitions-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore">Restore a soft-deleted custom field definition</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-dropdown" class="tocify-header">
                <li class="tocify-item level-1" data-unique="dropdown">
                    <a href="#dropdown">Dropdown</a>
                </li>
                                    <ul id="tocify-subheader-dropdown" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="dropdown-GETapi-v1-dropdown">
                                <a href="#dropdown-GETapi-v1-dropdown">getDropdown - Api to get dropdown data.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: November 10, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your Bearer token by authenticating via the login endpoint.</p>

        <h1 id="contact-merge">Contact Merge</h1>

    <p>APIs for merging contacts. Allows combining two contacts into one while preserving all data.</p>

                                <h2 id="contact-merge-POSTapi-v1-contacts-merge-preview">Preview merge</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Preview what will happen when two contacts are merged. Shows differences and data that will be combined.</p>

<span id="example-requests-POSTapi-v1-contacts-merge-preview">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/contacts/merge/preview" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"master_id\": \"abc123xyz\",
    \"secondary_id\": \"xyz456abc\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts/merge/preview"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "master_id": "abc123xyz",
    "secondary_id": "xyz456abc"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-contacts-merge-preview">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Merge preview retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;master&quot;: {
            &quot;id&quot;: &quot;abc123xyz&quot;,
            &quot;first_name&quot;: &quot;John&quot;,
            &quot;last_name&quot;: &quot;Doe&quot;,
            &quot;company&quot;: &quot;Acme Corp&quot;,
            &quot;job_title&quot;: &quot;Manager&quot;,
            &quot;status&quot;: 1,
            &quot;emails&quot;: [
                {
                    &quot;id&quot;: &quot;email1&quot;,
                    &quot;email&quot;: &quot;john.doe@acme.com&quot;,
                    &quot;is_primary&quot;: true
                }
            ],
            &quot;phones&quot;: [
                {
                    &quot;id&quot;: &quot;phone1&quot;,
                    &quot;phone&quot;: &quot;+1234567890&quot;,
                    &quot;is_primary&quot;: true
                }
            ],
            &quot;custom_fields&quot;: [
                {
                    &quot;field_id&quot;: &quot;field1&quot;,
                    &quot;field_name&quot;: &quot;department&quot;,
                    &quot;value&quot;: &quot;Sales&quot;
                }
            ]
        },
        &quot;secondary&quot;: {
            &quot;id&quot;: &quot;xyz456abc&quot;,
            &quot;first_name&quot;: &quot;John&quot;,
            &quot;last_name&quot;: &quot;Doe&quot;,
            &quot;company&quot;: &quot;Acme Corporation&quot;,
            &quot;job_title&quot;: &quot;Senior Manager&quot;,
            &quot;status&quot;: 1,
            &quot;emails&quot;: [
                {
                    &quot;id&quot;: &quot;email2&quot;,
                    &quot;email&quot;: &quot;j.doe@acme.com&quot;,
                    &quot;is_primary&quot;: true
                },
                {
                    &quot;id&quot;: &quot;email3&quot;,
                    &quot;email&quot;: &quot;john.doe@acme.com&quot;,
                    &quot;is_primary&quot;: false
                }
            ],
            &quot;phones&quot;: [
                {
                    &quot;id&quot;: &quot;phone2&quot;,
                    &quot;phone&quot;: &quot;+0987654321&quot;,
                    &quot;is_primary&quot;: true
                }
            ],
            &quot;custom_fields&quot;: [
                {
                    &quot;field_id&quot;: &quot;field1&quot;,
                    &quot;field_name&quot;: &quot;department&quot;,
                    &quot;value&quot;: &quot;Marketing&quot;
                },
                {
                    &quot;field_id&quot;: &quot;field2&quot;,
                    &quot;field_name&quot;: &quot;region&quot;,
                    &quot;value&quot;: &quot;North America&quot;
                }
            ]
        },
        &quot;differences&quot;: {
            &quot;standard_fields&quot;: {
                &quot;company&quot;: {
                    &quot;master&quot;: &quot;Acme Corp&quot;,
                    &quot;secondary&quot;: &quot;Acme Corporation&quot;
                },
                &quot;job_title&quot;: {
                    &quot;master&quot;: &quot;Manager&quot;,
                    &quot;secondary&quot;: &quot;Senior Manager&quot;
                }
            },
            &quot;emails&quot;: {
                &quot;to_add&quot;: [
                    {
                        &quot;id&quot;: &quot;email2&quot;,
                        &quot;email&quot;: &quot;j.doe@acme.com&quot;,
                        &quot;is_primary&quot;: false
                    }
                ],
                &quot;duplicates&quot;: [
                    {
                        &quot;id&quot;: &quot;email3&quot;,
                        &quot;email&quot;: &quot;john.doe@acme.com&quot;
                    }
                ]
            },
            &quot;phones&quot;: {
                &quot;to_add&quot;: [
                    {
                        &quot;id&quot;: &quot;phone2&quot;,
                        &quot;phone&quot;: &quot;+0987654321&quot;,
                        &quot;is_primary&quot;: false
                    }
                ],
                &quot;duplicates&quot;: []
            },
            &quot;custom_fields&quot;: {
                &quot;conflicts&quot;: [
                    {
                        &quot;field_id&quot;: &quot;field1&quot;,
                        &quot;field_name&quot;: &quot;department&quot;,
                        &quot;master_value&quot;: &quot;Sales&quot;,
                        &quot;secondary_value&quot;: &quot;Marketing&quot;
                    }
                ],
                &quot;to_add&quot;: [
                    {
                        &quot;field_id&quot;: &quot;field2&quot;,
                        &quot;field_name&quot;: &quot;region&quot;,
                        &quot;value&quot;: &quot;North America&quot;
                    }
                ]
            }
        },
        &quot;merge_policies&quot;: {
            &quot;email_policy&quot;: [
                &quot;merge_all&quot;,
                &quot;primary_only&quot;
            ],
            &quot;phone_policy&quot;: [
                &quot;merge_all&quot;,
                &quot;primary_only&quot;
            ],
            &quot;custom_field_policy&quot;: [
                &quot;keep_master_unless_empty&quot;,
                &quot;keep_master_always&quot;,
                &quot;append_both&quot;
            ]
        }
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Contact Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;One or both contacts not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation Error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Cannot merge a contact with itself&quot;,
    &quot;errors&quot;: {
        &quot;master_id&quot;: [
            &quot;The master id and secondary id must be different.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-contacts-merge-preview" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-contacts-merge-preview"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-contacts-merge-preview"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-contacts-merge-preview" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-contacts-merge-preview">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-contacts-merge-preview" data-method="POST"
      data-path="api/v1/contacts/merge/preview"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-contacts-merge-preview', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-contacts-merge-preview"
                    onclick="tryItOut('POSTapi-v1-contacts-merge-preview');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-contacts-merge-preview"
                    onclick="cancelTryOut('POSTapi-v1-contacts-merge-preview');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-contacts-merge-preview"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/contacts/merge/preview</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-contacts-merge-preview"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-contacts-merge-preview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-contacts-merge-preview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>master_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="master_id"                data-endpoint="POSTapi-v1-contacts-merge-preview"
               value="abc123xyz"
               data-component="body">
    <br>
<p>Encrypted ID of the master contact (will be kept). Example: <code>abc123xyz</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>secondary_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="secondary_id"                data-endpoint="POSTapi-v1-contacts-merge-preview"
               value="xyz456abc"
               data-component="body">
    <br>
<p>Encrypted ID of the secondary contact (will be merged into master). Example: <code>xyz456abc</code></p>
        </div>
        </form>

                    <h2 id="contact-merge-POSTapi-v1-contacts-merge-execute">Execute merge</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Merge two contacts into one. The secondary contact will be marked as merged and all its data will be transferred to the master contact.</p>

<span id="example-requests-POSTapi-v1-contacts-merge-execute">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/contacts/merge/execute" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"master_id\": \"abc123xyz\",
    \"secondary_id\": \"xyz456abc\",
    \"merge_options\": {
        \"email_policy\": \"merge_all\",
        \"phone_policy\": \"merge_all\",
        \"custom_field_policies\": [
            \"none\"
        ],
        \"confirmed\": true,
        \"custom_field_policy\": \"keep_master_unless_empty\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts/merge/execute"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "master_id": "abc123xyz",
    "secondary_id": "xyz456abc",
    "merge_options": {
        "email_policy": "merge_all",
        "phone_policy": "merge_all",
        "custom_field_policies": [
            "none"
        ],
        "confirmed": true,
        "custom_field_policy": "keep_master_unless_empty"
    }
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-contacts-merge-execute">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contacts merged successfully&quot;,
    &quot;data&quot;: {
        &quot;merged_contact&quot;: {
            &quot;id&quot;: &quot;abc123xyz&quot;,
            &quot;first_name&quot;: &quot;John&quot;,
            &quot;last_name&quot;: &quot;Doe&quot;,
            &quot;company&quot;: &quot;Acme Corp&quot;,
            &quot;job_title&quot;: &quot;Manager&quot;,
            &quot;status&quot;: 1,
            &quot;emails&quot;: [
                {
                    &quot;id&quot;: &quot;email1&quot;,
                    &quot;email&quot;: &quot;john.doe@acme.com&quot;,
                    &quot;is_primary&quot;: true
                },
                {
                    &quot;id&quot;: &quot;email2&quot;,
                    &quot;email&quot;: &quot;j.doe@acme.com&quot;,
                    &quot;is_primary&quot;: false
                }
            ],
            &quot;phones&quot;: [
                {
                    &quot;id&quot;: &quot;phone1&quot;,
                    &quot;phone&quot;: &quot;+1234567890&quot;,
                    &quot;is_primary&quot;: true
                },
                {
                    &quot;id&quot;: &quot;phone2&quot;,
                    &quot;phone&quot;: &quot;+0987654321&quot;,
                    &quot;is_primary&quot;: false
                }
            ],
            &quot;custom_fields&quot;: [
                {
                    &quot;field_id&quot;: &quot;field1&quot;,
                    &quot;field_name&quot;: &quot;department&quot;,
                    &quot;value&quot;: &quot;Sales&quot;
                },
                {
                    &quot;field_id&quot;: &quot;field2&quot;,
                    &quot;field_name&quot;: &quot;region&quot;,
                    &quot;value&quot;: &quot;North America&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2024-01-01T00:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;
        },
        &quot;summary&quot;: {
            &quot;emails_added&quot;: 2,
            &quot;phones_added&quot;: 1,
            &quot;custom_fields_added&quot;: 3,
            &quot;custom_fields_updated&quot;: 1
        }
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400, Merge Failed):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Master contact is already merged&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation Error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;The given data was invalid&quot;,
    &quot;errors&quot;: {
        &quot;merge_options.confirmed&quot;: [
            &quot;The merge options.confirmed must be accepted.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-contacts-merge-execute" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-contacts-merge-execute"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-contacts-merge-execute"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-contacts-merge-execute" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-contacts-merge-execute">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-contacts-merge-execute" data-method="POST"
      data-path="api/v1/contacts/merge/execute"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-contacts-merge-execute', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-contacts-merge-execute"
                    onclick="tryItOut('POSTapi-v1-contacts-merge-execute');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-contacts-merge-execute"
                    onclick="cancelTryOut('POSTapi-v1-contacts-merge-execute');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-contacts-merge-execute"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/contacts/merge/execute</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>master_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="master_id"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="abc123xyz"
               data-component="body">
    <br>
<p>Encrypted ID of the master contact (will be kept). Example: <code>abc123xyz</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>secondary_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="secondary_id"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="xyz456abc"
               data-component="body">
    <br>
<p>Encrypted ID of the secondary contact (will be merged into master). Example: <code>xyz456abc</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>merge_options</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Merge options and policies.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email_policy</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="merge_options.email_policy"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="merge_all"
               data-component="body">
    <br>
<p>Email merge policy (merge_all, primary_only). Default: merge_all. Example: <code>merge_all</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone_policy</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="merge_options.phone_policy"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="merge_all"
               data-component="body">
    <br>
<p>Phone merge policy (merge_all, primary_only). Default: merge_all. Example: <code>merge_all</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>custom_field_policies</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="merge_options.custom_field_policies[0]"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               data-component="body">
        <input type="text" style="display: none"
               name="merge_options.custom_field_policies[1]"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               data-component="body">
    <br>

Must be one of:
<ul style="list-style-type: square;"><li><code>master</code></li> <li><code>secondary</code></li> <li><code>both</code></li> <li><code>none</code></li></ul>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>confirmed</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-contacts-merge-execute" style="display: none">
            <input type="radio" name="merge_options.confirmed"
                   value="true"
                   data-endpoint="POSTapi-v1-contacts-merge-execute"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-contacts-merge-execute" style="display: none">
            <input type="radio" name="merge_options.confirmed"
                   value="false"
                   data-endpoint="POSTapi-v1-contacts-merge-execute"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Must be true to confirm the merge. Example: <code>true</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>custom_field_policy</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="merge_options.custom_field_policy"                data-endpoint="POSTapi-v1-contacts-merge-execute"
               value="keep_master_unless_empty"
               data-component="body">
    <br>
<p>Custom field merge policy (keep_master_unless_empty, keep_master_always, append_both). Default: keep_master_unless_empty. Example: <code>keep_master_unless_empty</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                <h1 id="contacts">Contacts</h1>

    <p>APIs for managing contacts. Contacts can have custom fields, multiple emails, and multiple phones.</p>

                                <h2 id="contacts-GETapi-v1-contacts">List contacts</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieve a paginated listing of contacts with filtering, sorting, and search capabilities.</p>

<span id="example-requests-GETapi-v1-contacts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/contacts?search=john&amp;per_page=15&amp;order=desc&amp;expression=name&amp;trashed=with&amp;gender=Male&amp;is_merged=&amp;custom_fields[]=1&amp;custom_fields[]=2" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"search\": \"b\",
    \"per_page\": 22,
    \"order\": \"asc\",
    \"expression\": \"created_at\",
    \"trashed\": \"WITH_TRASHED\",
    \"gender\": \"3\",
    \"is_merged\": true,
    \"custom_fields\": [
        16
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts"
);

const params = {
    "search": "john",
    "per_page": "15",
    "order": "desc",
    "expression": "name",
    "trashed": "with",
    "gender": "Male",
    "is_merged": "0",
    "custom_fields[0]": "1",
    "custom_fields[1]": "2",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "search": "b",
    "per_page": 22,
    "order": "asc",
    "expression": "created_at",
    "trashed": "WITH_TRASHED",
    "gender": "3",
    "is_merged": true,
    "custom_fields": [
        16
    ]
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-contacts">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contact list retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;list&quot;: [
            {
                &quot;id&quot;: &quot;abc123xyz&quot;,
                &quot;name&quot;: &quot;John Doe&quot;,
                &quot;email&quot;: &quot;john.doe@example.com&quot;,
                &quot;phone&quot;: &quot;+1234567890&quot;,
                &quot;gender&quot;: &quot;Male&quot;,
                &quot;profile_image&quot;: &quot;https://example.com/storage/profiles/john-doe.jpg&quot;,
                &quot;additional_file&quot;: &quot;https://example.com/storage/documents/john-resume.pdf&quot;,
                &quot;is_merged&quot;: false,
                &quot;is_merge_locked&quot;: false,
                &quot;can_merge&quot;: true,
                &quot;merged_into_id&quot;: null,
                &quot;secondary_contact_id&quot;: null,
                &quot;merged_at&quot;: null,
                &quot;emails&quot;: [
                    {
                        &quot;id&quot;: &quot;email123&quot;,
                        &quot;email&quot;: &quot;john.work@example.com&quot;,
                        &quot;email_type&quot;: &quot;work&quot;,
                        &quot;is_primary&quot;: false,
                        &quot;source_contact_id&quot;: null,
                        &quot;creator_name&quot;: &quot;Admin User&quot;,
                        &quot;updater_name&quot;: &quot;Admin User&quot;,
                        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
                    }
                ],
                &quot;phones&quot;: [
                    {
                        &quot;id&quot;: &quot;phone123&quot;,
                        &quot;phone&quot;: &quot;+1234567891&quot;,
                        &quot;phone_type&quot;: &quot;mobile&quot;,
                        &quot;is_primary&quot;: false,
                        &quot;source_contact_id&quot;: null,
                        &quot;creator_name&quot;: &quot;Admin User&quot;,
                        &quot;updater_name&quot;: &quot;Admin User&quot;,
                        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
                    }
                ],
                &quot;custom_field_values&quot;: [
                    {
                        &quot;id&quot;: &quot;cfv123&quot;,
                        &quot;field_value&quot;: &quot;1990-05-15&quot;,
                        &quot;custom_field_id&quot;: &quot;cf1&quot;,
                        &quot;source_contact_id&quot;: null,
                        &quot;custom_field&quot;: {
                            &quot;id&quot;: &quot;cf1&quot;,
                            &quot;field_name&quot;: &quot;date_of_birth&quot;,
                            &quot;field_label&quot;: &quot;Date of Birth&quot;,
                            &quot;field_type&quot;: &quot;date&quot;,
                            &quot;field_options&quot;: null,
                            &quot;is_required&quot;: false
                        },
                        &quot;creator_name&quot;: &quot;Admin User&quot;,
                        &quot;updater_name&quot;: &quot;Admin User&quot;,
                        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
                    },
                    {
                        &quot;id&quot;: &quot;cfv124&quot;,
                        &quot;field_value&quot;: &quot;Tech Corp&quot;,
                        &quot;custom_field_id&quot;: &quot;cf2&quot;,
                        &quot;source_contact_id&quot;: null,
                        &quot;custom_field&quot;: {
                            &quot;id&quot;: &quot;cf2&quot;,
                            &quot;field_name&quot;: &quot;company&quot;,
                            &quot;field_label&quot;: &quot;Company&quot;,
                            &quot;field_type&quot;: &quot;text&quot;,
                            &quot;field_options&quot;: null,
                            &quot;is_required&quot;: false
                        },
                        &quot;creator_name&quot;: &quot;Admin User&quot;,
                        &quot;updater_name&quot;: &quot;Admin User&quot;,
                        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
                    }
                ],
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;deleted_at&quot;: null
            },
            {
                &quot;id&quot;: &quot;def456uvw&quot;,
                &quot;name&quot;: &quot;Jane Smith&quot;,
                &quot;email&quot;: &quot;jane.smith@example.com&quot;,
                &quot;phone&quot;: &quot;+1987654320&quot;,
                &quot;gender&quot;: &quot;Female&quot;,
                &quot;profile_image&quot;: &quot;https://example.com/storage/profiles/jane-smith.jpg&quot;,
                &quot;additional_file&quot;: null,
                &quot;is_merged&quot;: false,
                &quot;is_merge_locked&quot;: false,
                &quot;can_merge&quot;: true,
                &quot;merged_into_id&quot;: null,
                &quot;secondary_contact_id&quot;: null,
                &quot;merged_at&quot;: null,
                &quot;emails&quot;: [],
                &quot;phones&quot;: [],
                &quot;custom_field_values&quot;: [],
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-14 09:15:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-14 09:15:00&quot;,
                &quot;deleted_at&quot;: null
            }
        ],
        &quot;pagination&quot;: {
            &quot;current_page&quot;: 1,
            &quot;next_page&quot;: 2,
            &quot;from&quot;: 1,
            &quot;last_page&quot;: 5,
            &quot;per_page&quot;: 15,
            &quot;to&quot;: 15,
            &quot;total&quot;: 68
        }
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-contacts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-contacts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-contacts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-contacts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-contacts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-contacts" data-method="GET"
      data-path="api/v1/contacts"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-contacts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-contacts"
                    onclick="tryItOut('GETapi-v1-contacts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-contacts"
                    onclick="cancelTryOut('GETapi-v1-contacts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-contacts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/contacts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-contacts"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-contacts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-contacts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v1-contacts"
               value="john"
               data-component="query">
    <br>
<p>Filter by name, email, or phone. Example: <code>john</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-contacts"
               value="15"
               data-component="query">
    <br>
<p>Number of items per page. Defaults to system default. Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="order"                data-endpoint="GETapi-v1-contacts"
               value="desc"
               data-component="query">
    <br>
<p>Sort order (asc or desc). Defaults to 'desc'. Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>expression</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="expression"                data-endpoint="GETapi-v1-contacts"
               value="name"
               data-component="query">
    <br>
<p>Field to sort by. Defaults to 'created_at'. Example: <code>name</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>trashed</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="trashed"                data-endpoint="GETapi-v1-contacts"
               value="with"
               data-component="query">
    <br>
<p>Include trashed items ('with', 'only', or null). Example: <code>with</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>gender</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gender"                data-endpoint="GETapi-v1-contacts"
               value="Male"
               data-component="query">
    <br>
<p>Filter by gender (Male, Female, Other). Example: <code>Male</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>is_merged</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-contacts" style="display: none">
            <input type="radio" name="is_merged"
                   value="1"
                   data-endpoint="GETapi-v1-contacts"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-contacts" style="display: none">
            <input type="radio" name="is_merged"
                   value="0"
                   data-endpoint="GETapi-v1-contacts"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter by merged status (true/false). Example: <code>false</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>custom_fields</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="custom_fields[0]"                data-endpoint="GETapi-v1-contacts"
               data-component="query">
        <input type="text" style="display: none"
               name="custom_fields[1]"                data-endpoint="GETapi-v1-contacts"
               data-component="query">
    <br>
<p>Filter by custom field</p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v1-contacts"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-contacts"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="order"                data-endpoint="GETapi-v1-contacts"
               value="asc"
               data-component="body">
    <br>
<p>Example: <code>asc</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>asc</code></li> <li><code>desc</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>expression</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="expression"                data-endpoint="GETapi-v1-contacts"
               value="created_at"
               data-component="body">
    <br>
<p>Example: <code>created_at</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>name</code></li> <li><code>email</code></li> <li><code>phone</code></li> <li><code>gender</code></li> <li><code>created_at</code></li> <li><code>updated_at</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>trashed</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="trashed"                data-endpoint="GETapi-v1-contacts"
               value="WITH_TRASHED"
               data-component="body">
    <br>
<p>Example: <code>WITH_TRASHED</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>ONLY_TRASHED</code></li> <li><code>WITH_TRASHED</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gender</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gender"                data-endpoint="GETapi-v1-contacts"
               value="3"
               data-component="body">
    <br>
<p>Example: <code>3</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li> <li><code>3</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_merged</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-contacts" style="display: none">
            <input type="radio" name="is_merged"
                   value="true"
                   data-endpoint="GETapi-v1-contacts"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-contacts" style="display: none">
            <input type="radio" name="is_merged"
                   value="false"
                   data-endpoint="GETapi-v1-contacts"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>custom_fields</code></b>&nbsp;&nbsp;
<small>integer[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="custom_fields[0]"                data-endpoint="GETapi-v1-contacts"
               data-component="body">
        <input type="number" style="display: none"
               name="custom_fields[1]"                data-endpoint="GETapi-v1-contacts"
               data-component="body">
    <br>

        </div>
        </form>

                    <h2 id="contacts-POSTapi-v1-contacts">Create a contact</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created contact in the database with custom fields, emails, and phones.</p>

<span id="example-requests-POSTapi-v1-contacts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/contacts" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "name=John Doe"\
    --form "email=john.doe@example.com"\
    --form "phone=+1234567890"\
    --form "gender=Male"\
    --form "additional_emails[]=architecto"\
    --form "additional_phones[]=architecto"\
    --form "profile_image=@/tmp/phpqi6v3gmicqqkdX9ZfdV" \
    --form "additional_file=@/tmp/phpbfpu90mlvafja7ApG5a" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('name', 'John Doe');
body.append('email', 'john.doe@example.com');
body.append('phone', '+1234567890');
body.append('gender', 'Male');
body.append('additional_emails[]', 'architecto');
body.append('additional_phones[]', 'architecto');
body.append('profile_image', document.querySelector('input[name="profile_image"]').files[0]);
body.append('additional_file', document.querySelector('input[name="additional_file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-contacts">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contact created successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;abc123xyz&quot;,
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;phone&quot;: &quot;+1234567890&quot;,
        &quot;gender&quot;: &quot;Male&quot;,
        &quot;profile_image&quot;: &quot;https://example.com/storage/profiles/john-doe.jpg&quot;,
        &quot;additional_file&quot;: &quot;https://example.com/storage/documents/john-resume.pdf&quot;,
        &quot;is_merged&quot;: false,
        &quot;is_merge_locked&quot;: false,
        &quot;can_merge&quot;: true,
        &quot;merged_into_id&quot;: null,
        &quot;secondary_contact_id&quot;: null,
        &quot;merged_at&quot;: null,
        &quot;emails&quot;: [
            {
                &quot;id&quot;: &quot;email123&quot;,
                &quot;email&quot;: &quot;john.work@example.com&quot;,
                &quot;email_type&quot;: &quot;work&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;phones&quot;: [
            {
                &quot;id&quot;: &quot;phone123&quot;,
                &quot;phone&quot;: &quot;+1234567891&quot;,
                &quot;phone_type&quot;: &quot;mobile&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;custom_field_values&quot;: [
            {
                &quot;id&quot;: &quot;cfv123&quot;,
                &quot;field_value&quot;: &quot;1990-05-15&quot;,
                &quot;custom_field_id&quot;: &quot;cf1&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf1&quot;,
                    &quot;field_name&quot;: &quot;date_of_birth&quot;,
                    &quot;field_label&quot;: &quot;Date of Birth&quot;,
                    &quot;field_type&quot;: &quot;date&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            },
            {
                &quot;id&quot;: &quot;cfv124&quot;,
                &quot;field_value&quot;: &quot;Tech Corp&quot;,
                &quot;custom_field_id&quot;: &quot;cf2&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf2&quot;,
                    &quot;field_name&quot;: &quot;company&quot;,
                    &quot;field_label&quot;: &quot;Company&quot;,
                    &quot;field_type&quot;: &quot;text&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;creator_name&quot;: &quot;Admin User&quot;,
        &quot;updater_name&quot;: &quot;Admin User&quot;,
        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;deleted_at&quot;: null
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation Error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;The given data was invalid&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Contact name is required&quot;
        ],
        &quot;email&quot;: [
            &quot;This email address is already registered&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-contacts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-contacts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-contacts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-contacts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-contacts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-contacts" data-method="POST"
      data-path="api/v1/contacts"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-contacts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-contacts"
                    onclick="tryItOut('POSTapi-v1-contacts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-contacts"
                    onclick="cancelTryOut('POSTapi-v1-contacts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-contacts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/contacts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-contacts"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-contacts"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-contacts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-contacts"
               value="John Doe"
               data-component="body">
    <br>
<p>Contact name. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-contacts"
               value="john.doe@example.com"
               data-component="body">
    <br>
<p>Contact email (must be unique). Example: <code>john.doe@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-contacts"
               value="+1234567890"
               data-component="body">
    <br>
<p>Contact phone number. Example: <code>+1234567890</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gender</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gender"                data-endpoint="POSTapi-v1-contacts"
               value="Male"
               data-component="body">
    <br>
<p>Gender (Male, Female, Other). Example: <code>Male</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>profile_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="profile_image"                data-endpoint="POSTapi-v1-contacts"
               value=""
               data-component="body">
    <br>
<p>Profile image (jpeg, jpg, png, gif, webp, max 2MB). Example: <code>/tmp/phpqi6v3gmicqqkdX9ZfdV</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>additional_file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="additional_file"                data-endpoint="POSTapi-v1-contacts"
               value=""
               data-component="body">
    <br>
<p>Additional document (pdf, doc, docx, xls, xlsx, txt, zip, max 5MB). Example: <code>/tmp/phpbfpu90mlvafja7ApG5a</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>additional_emails</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Additional email addresses.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_emails.0.email"                data-endpoint="POSTapi-v1-contacts"
               value="john.work@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>john.work@example.com</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_emails.0.email_type"                data-endpoint="POSTapi-v1-contacts"
               value="work"
               data-component="body">
    <br>
<p>Email type (work, personal, other). Example: <code>work</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-contacts" style="display: none">
            <input type="radio" name="additional_emails.0.is_primary"
                   value="true"
                   data-endpoint="POSTapi-v1-contacts"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-contacts" style="display: none">
            <input type="radio" name="additional_emails.0.is_primary"
                   value="false"
                   data-endpoint="POSTapi-v1-contacts"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Is primary email. Example: <code>false</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>additional_phones</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Additional phone numbers.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_phones.0.phone"                data-endpoint="POSTapi-v1-contacts"
               value="+1234567891"
               data-component="body">
    <br>
<p>Phone number. Example: <code>+1234567891</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_phones.0.phone_type"                data-endpoint="POSTapi-v1-contacts"
               value="mobile"
               data-component="body">
    <br>
<p>Phone type (mobile, work, home, fax, other). Example: <code>mobile</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-contacts" style="display: none">
            <input type="radio" name="additional_phones.0.is_primary"
                   value="true"
                   data-endpoint="POSTapi-v1-contacts"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-contacts" style="display: none">
            <input type="radio" name="additional_phones.0.is_primary"
                   value="false"
                   data-endpoint="POSTapi-v1-contacts"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Is primary phone. Example: <code>false</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>custom_fields</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="custom_fields"                data-endpoint="POSTapi-v1-contacts"
               value=""
               data-component="body">
    <br>
<p>Custom field values (ID-value pairs).</p>
        </div>
        </form>

                    <h2 id="contacts-GETapi-v1-contacts--id-">Get a contact</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the details of a specific contact with complete information including audit logs and merge history.</p>

<span id="example-requests-GETapi-v1-contacts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/contacts/2" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts/2"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-contacts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contact retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;abc123xyz&quot;,
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;phone&quot;: &quot;+1234567890&quot;,
        &quot;gender&quot;: &quot;Male&quot;,
        &quot;profile_image&quot;: &quot;https://example.com/storage/profiles/john-doe.jpg&quot;,
        &quot;additional_file&quot;: &quot;https://example.com/storage/documents/john-resume.pdf&quot;,
        &quot;is_merged&quot;: false,
        &quot;is_merge_locked&quot;: false,
        &quot;can_merge&quot;: true,
        &quot;merged_into_id&quot;: null,
        &quot;secondary_contact_id&quot;: null,
        &quot;merged_at&quot;: null,
        &quot;emails&quot;: [
            {
                &quot;id&quot;: &quot;email123&quot;,
                &quot;email&quot;: &quot;john.work@example.com&quot;,
                &quot;email_type&quot;: &quot;work&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;phones&quot;: [
            {
                &quot;id&quot;: &quot;phone123&quot;,
                &quot;phone&quot;: &quot;+1234567891&quot;,
                &quot;phone_type&quot;: &quot;mobile&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;custom_field_values&quot;: [
            {
                &quot;id&quot;: &quot;cfv123&quot;,
                &quot;field_value&quot;: &quot;1990-05-15&quot;,
                &quot;custom_field_id&quot;: &quot;cf1&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf1&quot;,
                    &quot;field_name&quot;: &quot;date_of_birth&quot;,
                    &quot;field_label&quot;: &quot;Date of Birth&quot;,
                    &quot;field_type&quot;: &quot;date&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            },
            {
                &quot;id&quot;: &quot;cfv124&quot;,
                &quot;field_value&quot;: &quot;Tech Corp&quot;,
                &quot;custom_field_id&quot;: &quot;cf2&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf2&quot;,
                    &quot;field_name&quot;: &quot;company&quot;,
                    &quot;field_label&quot;: &quot;Company&quot;,
                    &quot;field_type&quot;: &quot;text&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;merged_into&quot;: null,
        &quot;secondary_contact&quot;: null,
        &quot;creator_name&quot;: &quot;Admin User&quot;,
        &quot;updater_name&quot;: &quot;Admin User&quot;,
        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;deleted_at&quot;: null
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Contact not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-contacts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-contacts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-contacts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-contacts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-contacts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-contacts--id-" data-method="GET"
      data-path="api/v1/contacts/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-contacts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-contacts--id-"
                    onclick="tryItOut('GETapi-v1-contacts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-contacts--id-"
                    onclick="cancelTryOut('GETapi-v1-contacts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-contacts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/contacts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-contacts--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-contacts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-contacts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-contacts--id-"
               value="2"
               data-component="url">
    <br>
<p>The ID of the contact. Example: <code>2</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contact</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="contact"                data-endpoint="GETapi-v1-contacts--id-"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the contact. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                    <h2 id="contacts-PUTapi-v1-contacts--id-">Update a contact</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the specified contact in the database.</p>

<span id="example-requests-PUTapi-v1-contacts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost:8000/api/v1/contacts/2" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "name=John Doe"\
    --form "email=john.doe@example.com"\
    --form "phone=+1234567890"\
    --form "gender=Male"\
    --form "additional_emails[]=architecto"\
    --form "additional_phones[]=architecto"\
    --form "profile_image=@/tmp/phpib49uotehg3n19hKW5W" \
    --form "additional_file=@/tmp/phpmi4co7t74vql83hqcqr" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts/2"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('name', 'John Doe');
body.append('email', 'john.doe@example.com');
body.append('phone', '+1234567890');
body.append('gender', 'Male');
body.append('additional_emails[]', 'architecto');
body.append('additional_phones[]', 'architecto');
body.append('profile_image', document.querySelector('input[name="profile_image"]').files[0]);
body.append('additional_file', document.querySelector('input[name="additional_file"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-contacts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contact updated successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;abc123xyz&quot;,
        &quot;name&quot;: &quot;John Doe Updated&quot;,
        &quot;email&quot;: &quot;john.doe.updated@example.com&quot;,
        &quot;phone&quot;: &quot;+1234567890&quot;,
        &quot;gender&quot;: &quot;Male&quot;,
        &quot;profile_image&quot;: &quot;https://example.com/storage/profiles/john-doe-updated.jpg&quot;,
        &quot;additional_file&quot;: &quot;https://example.com/storage/documents/john-resume-updated.pdf&quot;,
        &quot;is_merged&quot;: false,
        &quot;is_merge_locked&quot;: false,
        &quot;can_merge&quot;: true,
        &quot;merged_into_id&quot;: null,
        &quot;secondary_contact_id&quot;: null,
        &quot;merged_at&quot;: null,
        &quot;emails&quot;: [
            {
                &quot;id&quot;: &quot;email123&quot;,
                &quot;email&quot;: &quot;john.work@example.com&quot;,
                &quot;email_type&quot;: &quot;work&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 11:45:00&quot;
            }
        ],
        &quot;phones&quot;: [
            {
                &quot;id&quot;: &quot;phone123&quot;,
                &quot;phone&quot;: &quot;+1234567891&quot;,
                &quot;phone_type&quot;: &quot;mobile&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 11:45:00&quot;
            }
        ],
        &quot;custom_field_values&quot;: [
            {
                &quot;id&quot;: &quot;cfv123&quot;,
                &quot;field_value&quot;: &quot;1990-05-15&quot;,
                &quot;custom_field_id&quot;: &quot;cf1&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf1&quot;,
                    &quot;field_name&quot;: &quot;date_of_birth&quot;,
                    &quot;field_label&quot;: &quot;Date of Birth&quot;,
                    &quot;field_type&quot;: &quot;date&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 11:45:00&quot;
            },
            {
                &quot;id&quot;: &quot;cfv124&quot;,
                &quot;field_value&quot;: &quot;Tech Corp Updated&quot;,
                &quot;custom_field_id&quot;: &quot;cf2&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf2&quot;,
                    &quot;field_name&quot;: &quot;company&quot;,
                    &quot;field_label&quot;: &quot;Company&quot;,
                    &quot;field_type&quot;: &quot;text&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 11:45:00&quot;
            }
        ],
        &quot;merged_into&quot;: null,
        &quot;secondary_contact&quot;: null,
        &quot;creator_name&quot;: &quot;Admin User&quot;,
        &quot;updater_name&quot;: &quot;Admin User&quot;,
        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;updated_at&quot;: &quot;2025-01-15 11:45:00&quot;,
        &quot;deleted_at&quot;: null
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Contact not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation Error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;The given data was invalid&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;This email address is already registered&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-v1-contacts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-contacts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-contacts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-contacts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-contacts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-contacts--id-" data-method="PUT"
      data-path="api/v1/contacts/{id}"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-contacts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-contacts--id-"
                    onclick="tryItOut('PUTapi-v1-contacts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-contacts--id-"
                    onclick="cancelTryOut('PUTapi-v1-contacts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-contacts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/contacts/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/contacts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-contacts--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-contacts--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-contacts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-v1-contacts--id-"
               value="2"
               data-component="url">
    <br>
<p>The ID of the contact. Example: <code>2</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contact</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="contact"                data-endpoint="PUTapi-v1-contacts--id-"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the contact. Example: <code>abc123xyz</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-v1-contacts--id-"
               value="John Doe"
               data-component="body">
    <br>
<p>Contact name. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PUTapi-v1-contacts--id-"
               value="john.doe@example.com"
               data-component="body">
    <br>
<p>Contact email (must be unique). Example: <code>john.doe@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PUTapi-v1-contacts--id-"
               value="+1234567890"
               data-component="body">
    <br>
<p>Contact phone number. Example: <code>+1234567890</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gender</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gender"                data-endpoint="PUTapi-v1-contacts--id-"
               value="Male"
               data-component="body">
    <br>
<p>Gender (Male, Female, Other). Example: <code>Male</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>profile_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="profile_image"                data-endpoint="PUTapi-v1-contacts--id-"
               value=""
               data-component="body">
    <br>
<p>Profile image (jpeg, jpg, png, gif, webp, max 2MB). Example: <code>/tmp/phpib49uotehg3n19hKW5W</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>additional_file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="additional_file"                data-endpoint="PUTapi-v1-contacts--id-"
               value=""
               data-component="body">
    <br>
<p>Additional document (pdf, doc, docx, xls, xlsx, txt, zip, max 5MB). Example: <code>/tmp/phpmi4co7t74vql83hqcqr</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>additional_emails</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Additional email addresses.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="additional_emails.0.id"                data-endpoint="PUTapi-v1-contacts--id-"
               value="16"
               data-component="body">
    <br>
<p>Existing email ID (for updates). Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_emails.0.email"                data-endpoint="PUTapi-v1-contacts--id-"
               value="john.work@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>john.work@example.com</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_emails.0.email_type"                data-endpoint="PUTapi-v1-contacts--id-"
               value="work"
               data-component="body">
    <br>
<p>Email type (work, personal, other). Example: <code>work</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-v1-contacts--id-" style="display: none">
            <input type="radio" name="additional_emails.0.is_primary"
                   value="true"
                   data-endpoint="PUTapi-v1-contacts--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-v1-contacts--id-" style="display: none">
            <input type="radio" name="additional_emails.0.is_primary"
                   value="false"
                   data-endpoint="PUTapi-v1-contacts--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Is primary email. Example: <code>false</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>additional_phones</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Additional phone numbers.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="additional_phones.0.id"                data-endpoint="PUTapi-v1-contacts--id-"
               value="16"
               data-component="body">
    <br>
<p>Existing phone ID (for updates). Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_phones.0.phone"                data-endpoint="PUTapi-v1-contacts--id-"
               value="+1234567891"
               data-component="body">
    <br>
<p>Phone number. Example: <code>+1234567891</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="additional_phones.0.phone_type"                data-endpoint="PUTapi-v1-contacts--id-"
               value="mobile"
               data-component="body">
    <br>
<p>Phone type (mobile, work, home, fax, other). Example: <code>mobile</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-v1-contacts--id-" style="display: none">
            <input type="radio" name="additional_phones.0.is_primary"
                   value="true"
                   data-endpoint="PUTapi-v1-contacts--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-v1-contacts--id-" style="display: none">
            <input type="radio" name="additional_phones.0.is_primary"
                   value="false"
                   data-endpoint="PUTapi-v1-contacts--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Is primary phone. Example: <code>false</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>custom_fields</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="custom_fields"                data-endpoint="PUTapi-v1-contacts--id-"
               value=""
               data-component="body">
    <br>
<p>Custom field values (ID-value pairs).</p>
        </div>
        </form>

                    <h2 id="contacts-DELETEapi-v1-contacts--id-">Delete a contact</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove the specified contact (soft delete).</p>

<span id="example-requests-DELETEapi-v1-contacts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost:8000/api/v1/contacts/2" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts/2"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-contacts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contact deleted successfully&quot;,
    &quot;data&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Contact not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-contacts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-contacts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-contacts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-contacts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-contacts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-contacts--id-" data-method="DELETE"
      data-path="api/v1/contacts/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-contacts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-contacts--id-"
                    onclick="tryItOut('DELETEapi-v1-contacts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-contacts--id-"
                    onclick="cancelTryOut('DELETEapi-v1-contacts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-contacts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/contacts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-contacts--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-contacts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-contacts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-contacts--id-"
               value="2"
               data-component="url">
    <br>
<p>The ID of the contact. Example: <code>2</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contact</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="contact"                data-endpoint="DELETEapi-v1-contacts--id-"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the contact. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                    <h2 id="contacts-PATCHapi-v1-contacts--contact--restore">Restore a contact</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Restore a soft-deleted contact.</p>

<span id="example-requests-PATCHapi-v1-contacts--contact--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost:8000/api/v1/contacts/abc123xyz/restore" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/contacts/abc123xyz/restore"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-contacts--contact--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Contact restored successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;abc123xyz&quot;,
        &quot;name&quot;: &quot;John Doe&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;phone&quot;: &quot;+1234567890&quot;,
        &quot;gender&quot;: &quot;Male&quot;,
        &quot;profile_image&quot;: &quot;https://example.com/storage/profiles/john-doe.jpg&quot;,
        &quot;additional_file&quot;: &quot;https://example.com/storage/documents/john-resume.pdf&quot;,
        &quot;is_merged&quot;: false,
        &quot;is_merge_locked&quot;: false,
        &quot;can_merge&quot;: true,
        &quot;merged_into_id&quot;: null,
        &quot;secondary_contact_id&quot;: null,
        &quot;merged_at&quot;: null,
        &quot;emails&quot;: [
            {
                &quot;id&quot;: &quot;email123&quot;,
                &quot;email&quot;: &quot;john.work@example.com&quot;,
                &quot;email_type&quot;: &quot;work&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;phones&quot;: [
            {
                &quot;id&quot;: &quot;phone123&quot;,
                &quot;phone&quot;: &quot;+1234567891&quot;,
                &quot;phone_type&quot;: &quot;mobile&quot;,
                &quot;is_primary&quot;: false,
                &quot;source_contact_id&quot;: null,
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;custom_field_values&quot;: [
            {
                &quot;id&quot;: &quot;cfv123&quot;,
                &quot;field_value&quot;: &quot;1990-05-15&quot;,
                &quot;custom_field_id&quot;: &quot;cf1&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf1&quot;,
                    &quot;field_name&quot;: &quot;date_of_birth&quot;,
                    &quot;field_label&quot;: &quot;Date of Birth&quot;,
                    &quot;field_type&quot;: &quot;date&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            },
            {
                &quot;id&quot;: &quot;cfv124&quot;,
                &quot;field_value&quot;: &quot;Tech Corp&quot;,
                &quot;custom_field_id&quot;: &quot;cf2&quot;,
                &quot;source_contact_id&quot;: null,
                &quot;custom_field&quot;: {
                    &quot;id&quot;: &quot;cf2&quot;,
                    &quot;field_name&quot;: &quot;company&quot;,
                    &quot;field_label&quot;: &quot;Company&quot;,
                    &quot;field_type&quot;: &quot;text&quot;,
                    &quot;field_options&quot;: null,
                    &quot;is_required&quot;: false
                },
                &quot;creator_name&quot;: &quot;Admin User&quot;,
                &quot;updater_name&quot;: &quot;Admin User&quot;,
                &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
                &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;
            }
        ],
        &quot;creator_name&quot;: &quot;Admin User&quot;,
        &quot;updater_name&quot;: &quot;Admin User&quot;,
        &quot;created_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;updated_at&quot;: &quot;2025-01-15 10:30:00&quot;,
        &quot;deleted_at&quot;: null
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Contact not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-v1-contacts--contact--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-contacts--contact--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-contacts--contact--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-contacts--contact--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-contacts--contact--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-contacts--contact--restore" data-method="PATCH"
      data-path="api/v1/contacts/{contact}/restore"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-contacts--contact--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-contacts--contact--restore"
                    onclick="tryItOut('PATCHapi-v1-contacts--contact--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-contacts--contact--restore"
                    onclick="cancelTryOut('PATCHapi-v1-contacts--contact--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-contacts--contact--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/contacts/{contact}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-contacts--contact--restore"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-contacts--contact--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-v1-contacts--contact--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contact</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="contact"                data-endpoint="PATCHapi-v1-contacts--contact--restore"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the contact. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                <h1 id="custom-field-definitions">Custom Field Definitions</h1>

    <p>APIs for managing custom field definitions for contacts. Custom fields allow you to extend contact data with additional fields.</p>

                                <h2 id="custom-field-definitions-GETapi-v1-custom-field-definitions">List custom field definitions</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieve a paginated listing of custom field definitions with filtering, sorting, and search capabilities.</p>

<span id="example-requests-GETapi-v1-custom-field-definitions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/custom-field-definitions?search=email_address&amp;per_page=15&amp;order=asc&amp;expression=display_order&amp;status=1&amp;trashed=with&amp;is_searchable=1&amp;is_required=&amp;field_type=text" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"expression\": \"field_type\",
    \"order\": \"asc\",
    \"page\": 16,
    \"per_page\": 16,
    \"search\": \"architecto\",
    \"status\": \"0\",
    \"trashed\": \"WITH_TRASHED\",
    \"is_searchable\": true,
    \"is_required\": true,
    \"field_type\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions"
);

const params = {
    "search": "email_address",
    "per_page": "15",
    "order": "asc",
    "expression": "display_order",
    "status": "1",
    "trashed": "with",
    "is_searchable": "1",
    "is_required": "0",
    "field_type": "text",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "expression": "field_type",
    "order": "asc",
    "page": 16,
    "per_page": 16,
    "search": "architecto",
    "status": "0",
    "trashed": "WITH_TRASHED",
    "is_searchable": true,
    "is_required": true,
    "field_type": "architecto"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-custom-field-definitions">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definitions retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;id&quot;: &quot;encrypted_id&quot;,
                &quot;name&quot;: &quot;preferred_contact_method&quot;,
                &quot;label&quot;: &quot;Preferred Contact Method&quot;,
                &quot;field_type&quot;: &quot;select&quot;,
                &quot;is_required&quot;: false,
                &quot;is_searchable&quot;: true,
                &quot;display_order&quot;: 1,
                &quot;status&quot;: 1,
                &quot;options&quot;: [
                    &quot;Email&quot;,
                    &quot;Phone&quot;,
                    &quot;SMS&quot;
                ],
                &quot;created_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;
            },
            {
                &quot;id&quot;: &quot;encrypted_id_2&quot;,
                &quot;name&quot;: &quot;customer_category&quot;,
                &quot;label&quot;: &quot;Customer Category&quot;,
                &quot;field_type&quot;: &quot;radio&quot;,
                &quot;is_required&quot;: true,
                &quot;is_searchable&quot;: true,
                &quot;display_order&quot;: 2,
                &quot;status&quot;: 1,
                &quot;options&quot;: [
                    &quot;Premium&quot;,
                    &quot;Standard&quot;,
                    &quot;Basic&quot;
                ],
                &quot;created_at&quot;: &quot;2025-01-02T00:00:00.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-01-02T00:00:00.000000Z&quot;
            }
        ],
        &quot;links&quot;: {
            &quot;first&quot;: &quot;http://localhost:8000/api/custom-field-definitions?page=1&quot;,
            &quot;last&quot;: &quot;http://localhost:8000/api/custom-field-definitions?page=1&quot;,
            &quot;prev&quot;: null,
            &quot;next&quot;: null
        },
        &quot;meta&quot;: {
            &quot;current_page&quot;: 1,
            &quot;from&quot;: 1,
            &quot;last_page&quot;: 1,
            &quot;path&quot;: &quot;http://localhost:8000/api/custom-field-definitions&quot;,
            &quot;per_page&quot;: 15,
            &quot;to&quot;: 2,
            &quot;total&quot;: 2
        }
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-custom-field-definitions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-custom-field-definitions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-custom-field-definitions"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-custom-field-definitions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-custom-field-definitions">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-custom-field-definitions" data-method="GET"
      data-path="api/v1/custom-field-definitions"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-custom-field-definitions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-custom-field-definitions"
                    onclick="tryItOut('GETapi-v1-custom-field-definitions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-custom-field-definitions"
                    onclick="cancelTryOut('GETapi-v1-custom-field-definitions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-custom-field-definitions"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/custom-field-definitions</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-custom-field-definitions"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="email_address"
               data-component="query">
    <br>
<p>Filter by field name or label. Example: <code>email_address</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="15"
               data-component="query">
    <br>
<p>Number of items per page. Defaults to system default. Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="order"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="asc"
               data-component="query">
    <br>
<p>Sort order (asc or desc). Defaults to 'asc'. Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>expression</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="expression"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="display_order"
               data-component="query">
    <br>
<p>Field to sort by. Defaults to 'display_order'. Example: <code>display_order</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="1"
               data-component="query">
    <br>
<p>Filter by active status (0=inactive, 1=active). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>trashed</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="trashed"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="with"
               data-component="query">
    <br>
<p>Include trashed items ('with', 'only', or null). Example: <code>with</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>is_searchable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_searchable"
                   value="1"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_searchable"
                   value="0"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter by searchable fields (true/false). Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>is_required</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_required"
                   value="1"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_required"
                   value="0"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter by required fields (true/false). Example: <code>false</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>field_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_type"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="text"
               data-component="query">
    <br>
<p>Filter by field type. Example: <code>text</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>expression</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="expression"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="field_type"
               data-component="body">
    <br>
<p>Example: <code>field_type</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>field_name</code></li> <li><code>field_label</code></li> <li><code>field_type</code></li> <li><code>display_order</code></li> <li><code>created_at</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="order"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="asc"
               data-component="body">
    <br>
<p>Example: <code>asc</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>asc</code></li> <li><code>desc</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="0"
               data-component="body">
    <br>
<p>Example: <code>0</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>0</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>trashed</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="trashed"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="WITH_TRASHED"
               data-component="body">
    <br>
<p>Example: <code>WITH_TRASHED</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>ONLY_TRASHED</code></li> <li><code>WITH_TRASHED</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_searchable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_searchable"
                   value="true"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_searchable"
                   value="false"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_required</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_required"
                   value="true"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_required"
                   value="false"
                   data-endpoint="GETapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_type"                data-endpoint="GETapi-v1-custom-field-definitions"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="custom-field-definitions-POSTapi-v1-custom-field-definitions">Create a custom field definition</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created custom field definition in the database.</p>

<span id="example-requests-POSTapi-v1-custom-field-definitions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/v1/custom-field-definitions" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"field_name\": \"b\",
    \"field_label\": \"n\",
    \"field_type\": \"select\",
    \"field_options\": [
        \"architecto\"
    ],
    \"is_required\": false,
    \"is_searchable\": true,
    \"display_order\": 1,
    \"status\": 1,
    \"name\": \"preferred_contact_method\",
    \"label\": \"Preferred Contact Method\",
    \"options\": [
        \"Email\",
        \"Phone\",
        \"SMS\"
    ],
    \"default_value\": \"Email\",
    \"help_text\": \"Choose the preferred way to contact this person\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "field_name": "b",
    "field_label": "n",
    "field_type": "select",
    "field_options": [
        "architecto"
    ],
    "is_required": false,
    "is_searchable": true,
    "display_order": 1,
    "status": 1,
    "name": "preferred_contact_method",
    "label": "Preferred Contact Method",
    "options": [
        "Email",
        "Phone",
        "SMS"
    ],
    "default_value": "Email",
    "help_text": "Choose the preferred way to contact this person"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-custom-field-definitions">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definition created successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;encrypted_id&quot;,
        &quot;name&quot;: &quot;preferred_contact_method&quot;,
        &quot;label&quot;: &quot;Preferred Contact Method&quot;,
        &quot;field_type&quot;: &quot;select&quot;,
        &quot;is_required&quot;: false,
        &quot;is_searchable&quot;: true,
        &quot;display_order&quot;: 1,
        &quot;status&quot;: 1,
        &quot;options&quot;: [
            &quot;Email&quot;,
            &quot;Phone&quot;,
            &quot;SMS&quot;
        ],
        &quot;default_value&quot;: &quot;Email&quot;,
        &quot;help_text&quot;: &quot;Choose the preferred way to contact this person&quot;,
        &quot;created_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation Error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;The given data was invalid&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;The name field is required.&quot;
        ],
        &quot;label&quot;: [
            &quot;The label field is required.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-custom-field-definitions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-custom-field-definitions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-custom-field-definitions"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-custom-field-definitions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-custom-field-definitions">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-custom-field-definitions" data-method="POST"
      data-path="api/v1/custom-field-definitions"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-custom-field-definitions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-custom-field-definitions"
                    onclick="tryItOut('POSTapi-v1-custom-field-definitions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-custom-field-definitions"
                    onclick="cancelTryOut('POSTapi-v1-custom-field-definitions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-custom-field-definitions"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/custom-field-definitions</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-custom-field-definitions"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_name"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="b"
               data-component="body">
    <br>
<p>Must contain only letters, numbers, dashes and underscores. Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_label"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_type"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="select"
               data-component="body">
    <br>
<p>Type of field (text, textarea, select, radio, date, number, email, url). Example: <code>select</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_options</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_options[0]"                data-endpoint="POSTapi-v1-custom-field-definitions"
               data-component="body">
        <input type="text" style="display: none"
               name="field_options[1]"                data-endpoint="POSTapi-v1-custom-field-definitions"
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_required</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_required"
                   value="true"
                   data-endpoint="POSTapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_required"
                   value="false"
                   data-endpoint="POSTapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether the field is required. Defaults to false. Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_searchable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_searchable"
                   value="true"
                   data-endpoint="POSTapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-custom-field-definitions" style="display: none">
            <input type="radio" name="is_searchable"
                   value="false"
                   data-endpoint="POSTapi-v1-custom-field-definitions"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether the field is searchable. Defaults to false. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>display_order</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="display_order"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="1"
               data-component="body">
    <br>
<p>Display order (lower numbers appear first). Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="1"
               data-component="body">
    <br>
<p>Active status (0=inactive, 1=active). Defaults to 1. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="preferred_contact_method"
               data-component="body">
    <br>
<p>Unique field name (snake_case). Example: <code>preferred_contact_method</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="Preferred Contact Method"
               data-component="body">
    <br>
<p>Display label for the field. Example: <code>Preferred Contact Method</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>options</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="options[0]"                data-endpoint="POSTapi-v1-custom-field-definitions"
               data-component="body">
        <input type="text" style="display: none"
               name="options[1]"                data-endpoint="POSTapi-v1-custom-field-definitions"
               data-component="body">
    <br>
<p>Field options for select/radio types.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>default_value</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="default_value"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="Email"
               data-component="body">
    <br>
<p>Default value for the field. Example: <code>Email</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>help_text</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="help_text"                data-endpoint="POSTapi-v1-custom-field-definitions"
               value="Choose the preferred way to contact this person"
               data-component="body">
    <br>
<p>Help text to display with the field. Example: <code>Choose the preferred way to contact this person</code></p>
        </div>
        </form>

                    <h2 id="custom-field-definitions-GETapi-v1-custom-field-definitions--id-">Get a custom field definition</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the details of a specific custom field definition.</p>

<span id="example-requests-GETapi-v1-custom-field-definitions--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/custom-field-definitions/16" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions/16"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-custom-field-definitions--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definition retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;encrypted_id&quot;,
        &quot;name&quot;: &quot;preferred_contact_method&quot;,
        &quot;label&quot;: &quot;Preferred Contact Method&quot;,
        &quot;field_type&quot;: &quot;select&quot;,
        &quot;is_required&quot;: false,
        &quot;is_searchable&quot;: true,
        &quot;display_order&quot;: 1,
        &quot;status&quot;: 1,
        &quot;options&quot;: [
            &quot;Email&quot;,
            &quot;Phone&quot;,
            &quot;SMS&quot;
        ],
        &quot;default_value&quot;: &quot;Email&quot;,
        &quot;help_text&quot;: &quot;Choose the preferred way to contact this person&quot;,
        &quot;created_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Custom field definition not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-custom-field-definitions--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-custom-field-definitions--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-custom-field-definitions--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-custom-field-definitions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-custom-field-definitions--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-custom-field-definitions--id-" data-method="GET"
      data-path="api/v1/custom-field-definitions/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-custom-field-definitions--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-custom-field-definitions--id-"
                    onclick="tryItOut('GETapi-v1-custom-field-definitions--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-custom-field-definitions--id-"
                    onclick="cancelTryOut('GETapi-v1-custom-field-definitions--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-custom-field-definitions--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/custom-field-definitions/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-custom-field-definitions--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-custom-field-definitions--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-custom-field-definitions--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-custom-field-definitions--id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the custom field definition. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinitionId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customFieldDefinitionId"                data-endpoint="GETapi-v1-custom-field-definitions--id-"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the custom field definition. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                    <h2 id="custom-field-definitions-PUTapi-v1-custom-field-definitions--id-">Update a custom field definition</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the specified custom field definition in the database.</p>

<span id="example-requests-PUTapi-v1-custom-field-definitions--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost:8000/api/v1/custom-field-definitions/16" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"field_name\": \"b\",
    \"field_label\": \"n\",
    \"field_type\": \"select\",
    \"field_options\": [
        \"architecto\"
    ],
    \"is_required\": false,
    \"is_searchable\": true,
    \"display_order\": 1,
    \"status\": 1,
    \"name\": \"preferred_contact_method\",
    \"label\": \"Preferred Contact Method\",
    \"options\": [
        \"Email\",
        \"Phone\",
        \"SMS\",
        \"In Person\"
    ],
    \"default_value\": \"Email\",
    \"help_text\": \"Choose the preferred way to contact this person\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions/16"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "field_name": "b",
    "field_label": "n",
    "field_type": "select",
    "field_options": [
        "architecto"
    ],
    "is_required": false,
    "is_searchable": true,
    "display_order": 1,
    "status": 1,
    "name": "preferred_contact_method",
    "label": "Preferred Contact Method",
    "options": [
        "Email",
        "Phone",
        "SMS",
        "In Person"
    ],
    "default_value": "Email",
    "help_text": "Choose the preferred way to contact this person"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-custom-field-definitions--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definition updated successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: &quot;encrypted_id&quot;,
        &quot;name&quot;: &quot;preferred_contact_method&quot;,
        &quot;label&quot;: &quot;Preferred Contact Method&quot;,
        &quot;field_type&quot;: &quot;select&quot;,
        &quot;is_required&quot;: false,
        &quot;is_searchable&quot;: true,
        &quot;display_order&quot;: 1,
        &quot;status&quot;: 1,
        &quot;options&quot;: [
            &quot;Email&quot;,
            &quot;Phone&quot;,
            &quot;SMS&quot;,
            &quot;In Person&quot;
        ],
        &quot;default_value&quot;: &quot;Email&quot;,
        &quot;help_text&quot;: &quot;Choose the preferred way to contact this person&quot;,
        &quot;created_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-01-01T00:00:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Custom field definition not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation Error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;The given data was invalid&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;The name has already been taken.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-v1-custom-field-definitions--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-custom-field-definitions--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-custom-field-definitions--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-custom-field-definitions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-custom-field-definitions--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-custom-field-definitions--id-" data-method="PUT"
      data-path="api/v1/custom-field-definitions/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-custom-field-definitions--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-custom-field-definitions--id-"
                    onclick="tryItOut('PUTapi-v1-custom-field-definitions--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-custom-field-definitions--id-"
                    onclick="cancelTryOut('PUTapi-v1-custom-field-definitions--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-custom-field-definitions--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/custom-field-definitions/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/custom-field-definitions/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the custom field definition. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinitionId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customFieldDefinitionId"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the custom field definition. Example: <code>abc123xyz</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_name"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="b"
               data-component="body">
    <br>
<p>Must contain only letters, numbers, dashes and underscores. Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_label"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_type"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="select"
               data-component="body">
    <br>
<p>Type of field (text, textarea, select, radio, date, number, email, url). Example: <code>select</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>field_options</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="field_options[0]"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="field_options[1]"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_required</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-v1-custom-field-definitions--id-" style="display: none">
            <input type="radio" name="is_required"
                   value="true"
                   data-endpoint="PUTapi-v1-custom-field-definitions--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-v1-custom-field-definitions--id-" style="display: none">
            <input type="radio" name="is_required"
                   value="false"
                   data-endpoint="PUTapi-v1-custom-field-definitions--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether the field is required. Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_searchable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-v1-custom-field-definitions--id-" style="display: none">
            <input type="radio" name="is_searchable"
                   value="true"
                   data-endpoint="PUTapi-v1-custom-field-definitions--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-v1-custom-field-definitions--id-" style="display: none">
            <input type="radio" name="is_searchable"
                   value="false"
                   data-endpoint="PUTapi-v1-custom-field-definitions--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether the field is searchable. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>display_order</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="display_order"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="1"
               data-component="body">
    <br>
<p>Display order (lower numbers appear first). Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="1"
               data-component="body">
    <br>
<p>Active status (0=inactive, 1=active). Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="preferred_contact_method"
               data-component="body">
    <br>
<p>Unique field name (snake_case). Example: <code>preferred_contact_method</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="Preferred Contact Method"
               data-component="body">
    <br>
<p>Display label for the field. Example: <code>Preferred Contact Method</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>options</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="options[0]"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="options[1]"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               data-component="body">
    <br>
<p>Field options for select/radio types.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>default_value</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="default_value"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="Email"
               data-component="body">
    <br>
<p>Default value for the field. Example: <code>Email</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>help_text</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="help_text"                data-endpoint="PUTapi-v1-custom-field-definitions--id-"
               value="Choose the preferred way to contact this person"
               data-component="body">
    <br>
<p>Help text to display with the field. Example: <code>Choose the preferred way to contact this person</code></p>
        </div>
        </form>

                    <h2 id="custom-field-definitions-DELETEapi-v1-custom-field-definitions--id-">Delete a custom field definition</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove the specified custom field definition (soft delete).</p>

<span id="example-requests-DELETEapi-v1-custom-field-definitions--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost:8000/api/v1/custom-field-definitions/16" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions/16"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-custom-field-definitions--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definition deleted successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Custom field definition not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-custom-field-definitions--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-custom-field-definitions--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-custom-field-definitions--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-custom-field-definitions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-custom-field-definitions--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-custom-field-definitions--id-" data-method="DELETE"
      data-path="api/v1/custom-field-definitions/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-custom-field-definitions--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-custom-field-definitions--id-"
                    onclick="tryItOut('DELETEapi-v1-custom-field-definitions--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-custom-field-definitions--id-"
                    onclick="cancelTryOut('DELETEapi-v1-custom-field-definitions--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-custom-field-definitions--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/custom-field-definitions/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-custom-field-definitions--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-custom-field-definitions--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-custom-field-definitions--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-custom-field-definitions--id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the custom field definition. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinitionId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customFieldDefinitionId"                data-endpoint="DELETEapi-v1-custom-field-definitions--id-"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the custom field definition. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                    <h2 id="custom-field-definitions-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status">Update status of a custom field definition</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Toggle the status of a custom field definition between active and inactive.</p>

<span id="example-requests-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost:8000/api/v1/custom-field-definitions/16/status" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions/16/status"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definition status updated successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Custom field definition not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status" data-method="PATCH"
      data-path="api/v1/custom-field-definitions/{customFieldDefinition}/status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-custom-field-definitions--customFieldDefinition--status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
                    onclick="tryItOut('PATCHapi-v1-custom-field-definitions--customFieldDefinition--status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
                    onclick="cancelTryOut('PATCHapi-v1-custom-field-definitions--customFieldDefinition--status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/custom-field-definitions/{customFieldDefinition}/status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinition</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customFieldDefinition"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
               value="16"
               data-component="url">
    <br>
<p>Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinitionId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customFieldDefinitionId"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--status"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the custom field definition. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                    <h2 id="custom-field-definitions-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore">Restore a soft-deleted custom field definition</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost:8000/api/v1/custom-field-definitions/16/restore" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/custom-field-definitions/16/restore"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Custom field definition restored successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Unauthorized):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not Found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Custom field definition not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore" data-method="PATCH"
      data-path="api/v1/custom-field-definitions/{customFieldDefinition}/restore"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
                    onclick="tryItOut('PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
                    onclick="cancelTryOut('PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/custom-field-definitions/{customFieldDefinition}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinition</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customFieldDefinition"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
               value="16"
               data-component="url">
    <br>
<p>Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customFieldDefinitionId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customFieldDefinitionId"                data-endpoint="PATCHapi-v1-custom-field-definitions--customFieldDefinition--restore"
               value="abc123xyz"
               data-component="url">
    <br>
<p>The encrypted ID of the custom field definition. Example: <code>abc123xyz</code></p>
            </div>
                    </form>

                <h1 id="dropdown">Dropdown</h1>

    

                                <h2 id="dropdown-GETapi-v1-dropdown">getDropdown - Api to get dropdown data.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-dropdown">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/v1/dropdown?type=architecto" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"type\": \"genders\",
    \"is_decrypted\": true,
    \"status\": \"0\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/v1/dropdown"
);

const params = {
    "type": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "genders",
    "is_decrypted": true,
    "status": "0"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-dropdown">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: X-Inertia
x-api-version: v1
x-api-supported-versions: v1
x-api-deprecation-info: https://api-docs.example.com/versioning
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IkxSeklxYmtnUTRtM3pmT1M4RUdyL1E9PSIsInZhbHVlIjoib1ZrREJsMjF2VTd3OXk2SGJVRUtVejBBRFJHQTVuZFpCd2FwQ1N4NUo5U0JmNitNaDd2cFNCc0JCRWJocm5pMG1hVkVNUit2NTV6aDAxRTlKd2l4eTZyUFBjZFlQaktaUkRTT0ZkTEFoT1Q0bDJBZlpxUlBaWEVpRStpbVJVY2IiLCJtYWMiOiIxNGMzMjJjZjkyYzE0ZWYyMTNiY2VmZTY0ZjE4ZWJjODI3NzllYTk0NWM5ZTUzZWQ0MDgzZTFjOTZkMGY3MWU0IiwidGFnIjoiIn0%3D; expires=Mon, 10 Nov 2025 20:13:56 GMT; Max-Age=7200; path=/; samesite=lax; crm_session=eyJpdiI6IkVsQmovYWs1TjFzQjNzMXhUQkFuSGc9PSIsInZhbHVlIjoibkZZcm10RkE4TS84bFBzSFBOVTEvcmFJMUd0NkpuOHNGWHVLaVdPN01PRWhTL3FYeHdtakFXb2Qrai9iMHVoMjhJN1BCb0hQUk9WaWRVVDN0WlR4b3RKK0ZvSzN2cEtrcnM3SFc0REtuRnVnaXY4T0c1N3pLRjRieTRXSVY2Q28iLCJtYWMiOiIwODdiY2ZiOGMzMmNhYWE4NmViZGYxZWVmYzA3MmVjMzZiM2QwYWE4MTlhOThmMzJkOTFkMjY1YjQzYzFkMzMxIiwidGFnIjoiIn0%3D; expires=Mon, 10 Nov 2025 20:13:56 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;message&quot;: &quot;Dropdown data retrieved successfully.&quot;,
    &quot;data&quot;: [
        {
            &quot;label&quot;: &quot;Male&quot;,
            &quot;value&quot;: 1
        },
        {
            &quot;label&quot;: &quot;Female&quot;,
            &quot;value&quot;: 2
        },
        {
            &quot;label&quot;: &quot;Other&quot;,
            &quot;value&quot;: 3
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-dropdown" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-dropdown"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-dropdown"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-dropdown" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-dropdown">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-dropdown" data-method="GET"
      data-path="api/v1/dropdown"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-dropdown', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-dropdown"
                    onclick="tryItOut('GETapi-v1-dropdown');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-dropdown"
                    onclick="cancelTryOut('GETapi-v1-dropdown');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-dropdown"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/dropdown</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-dropdown"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-dropdown"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-dropdown"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-v1-dropdown"
               value="architecto"
               data-component="query">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-v1-dropdown"
               value="genders"
               data-component="body">
    <br>
<p>Example: <code>genders</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>roles</code></li> <li><code>genders</code></li> <li><code>custom_field_definitions</code></li> <li><code>field_merge_policies</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_decrypted</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-dropdown" style="display: none">
            <input type="radio" name="is_decrypted"
                   value="true"
                   data-endpoint="GETapi-v1-dropdown"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-dropdown" style="display: none">
            <input type="radio" name="is_decrypted"
                   value="false"
                   data-endpoint="GETapi-v1-dropdown"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-v1-dropdown"
               value="0"
               data-component="body">
    <br>
<p>Example: <code>0</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>0</code></li></ul>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
