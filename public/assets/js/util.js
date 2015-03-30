//
// Copyright (c) 2007 Spotfire AB,
// Första Långgatan 26, SE-413 28 Göteborg, Sweden.
// All rights reserved.
//
// This software is the confidential and proprietary information
// of Spotfire AB ("Confidential Information"). You shall not
// disclose such Confidential Information and shall use it only
// in accordance with the terms of the license agreement you
// entered into with Spotfire.
//


// Fixes the missing indexOf function in IE.
if (!Array.prototype.indexOf)
{
    Array.prototype.indexOf = function(element)
    {
        for (var i = 0; i < this.length; i++)
        {
            if (this[i] == element)
            {
                return i;
            }
        }
        return -1;
    }
}

// Returns the width of the inner browser windows.
function getWindowInnerWidth()
{
    var width;
    if (window.innerWidth)
    {
        // All browsers but IE
        width = window.innerWidth;
    }
    else if (document.documentElement && document.documentElement.clientWidth)
    {
        // These functions are for IE6 when there is a DOCTYPE
        width = document.documentElement.clientWidth;
    }
    
    else if (document.body.clientWidth)
    {
        // These are for IE4, IE5, and IE6 without a DOCTYPE
        width = document.body.clientWidth;
    }
    return width || 0;
}

// Returns the height of the inner browser windows.
function getWindowInnerHeight()
{
    var height;
    if (window.innerHeight)
    {
        // All browsers but IE
        height = window.innerHeight;
    }
    else if (document.documentElement && document.documentElement.clientHeight)
    {
        // These functions are for IE6 when there is a DOCTYPE
        height = document.documentElement.clientHeight;
    }
    
    else if (document.body.clientHeight)
    {
        // These are for IE4, IE5, and IE6 without a DOCTYPE
        height = document.body.clientHeight;
    }
    return height || 0;
}

// Helper function to determine if an elements is defined.
function isDefined(arg)
{
    return typeof(arg) != "undefined";
}

// Determines if a string is null or empty.
function isNullOrEmpty(str)
{
    return (typeof(str) !== 'string' || str == null || str == "");
}