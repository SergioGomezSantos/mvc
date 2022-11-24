<?php

function fromIndex()
{
    echo "
        <div>
            <a href='Product/Show/1'>Show</a> | <a href='Product/Create'>Create</a>
        </div>
    ";
}

function redirectHome()
{
    echo "
        <div>
            <a href='/Product'>Index</a>
        </div>
    ";
}
