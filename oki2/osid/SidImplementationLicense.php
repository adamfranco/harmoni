<?php 
 
/**
 * <p>
 * MIT O.K.I&#46; SID Implementation License.
 * </p>
 * 
 * <p>
 * <b>Copyright and license statement:</b>
 * </p>
 * 
 * <p>
 * Copyright &copy; 2002-2004 Massachusetts Institute of     Technology
 * </p>
 * 
 * <p>
 * This work is being provided by the copyright holder(s)     subject to the
 * terms of the O.K.I&#46; SID Implementation     License. By obtaining, using
 * and/or copying this Work,     you agree that you have read, understand, and
 * will comply     with the O.K.I&#46; SID Implementation License.
 * </p>
 * 
 * <p>
 * THE WORK IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY     KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO     THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A     PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL     MASSACHUSETTS INSTITUTE OF TECHNOLOGY, THE AUTHORS,
 * OR     COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR     OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT     OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH     THE WORK OR THE USE OR OTHER
 * DEALINGS IN THE WORK.
 * </p>
 * 
 * <p>
 * <b>O.K.I&#46; SID Implementation License</b>
 * </p>
 * 
 * <p>
 * This work (the &ldquo;Work&rdquo;), including software,     documents, or
 * other items related to O.K.I&#46; SID     implementations, is being
 * provided by the copyright     holder(s) subject to the terms of the
 * O.K.I&#46; SID     Implementation License. By obtaining, using and/or
 * copying this Work, you agree that you have read,     understand, and will
 * comply with the following terms and     conditions of the O.K.I&#46; SID
 * Implementation License:
 * </p>
 * 
 * <p>
 * Permission to use, copy, modify, and distribute this Work     and its
 * documentation, with or without modification, for     any purpose and
 * without fee or royalty is hereby granted,     provided that you include the
 * following on ALL copies of     the Work or portions thereof, including
 * modifications or     derivatives, that you make:
 * </p>
 * 
 * <ul>
 * <li>
 * The full text of the O.K.I&#46; SID Implementation License in a location
 * viewable to users of the redistributed or derivative work.
 * </li>
 * </ul>
 * 
 * 
 * <ul>
 * <li>
 * Any pre-existing intellectual property disclaimers, notices, or terms and
 * conditions. If none exist, a short notice similar to the following should
 * be used within the body of any redistributed or derivative Work:
 * &ldquo;Copyright &copy; 2002-2004 Massachusetts Institute of Technology.
 * All Rights Reserved.&rdquo;
 * </li>
 * </ul>
 * 
 * 
 * <ul>
 * <li>
 * Notice of any changes or modifications to the O.K.I&#46; Work, including the
 * date the changes were made. Any modified software must be distributed in
 * such as manner as to avoid any confusion with the original O.K.I&#46; Work.
 * </li>
 * </ul>
 * 
 * <p>
 * THE WORK IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY     KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO     THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A     PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL     MASSACHUSETTS INSTITUTE OF TECHNOLOGY, THE AUTHORS,
 * OR     COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR     OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT     OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH     THE WORK OR THE USE OR OTHER
 * DEALINGS IN THE WORK.
 * </p>
 * 
 * <p>
 * The name and trademarks of copyright holder(s) and/or     O.K.I&#46; may NOT
 * be used in advertising or publicity     pertaining to the Work without
 * specific, written prior     permission. Title to copyright in the Work and
 * any     associated documentation will at all times remain with     the
 * copyright holders.
 * </p>
 * 
 * <p>
 * The export of software employing encryption technology     may require a
 * specific license from the United States     Government. It is the
 * responsibility of any person or     organization contemplating export to
 * obtain such a     license before exporting this Work.
 * </p>
 *
 * @version $Revision: 1.2 $ / $Date: 2005/01/19 16:33:32 $
 * 
 * @package org.osid
 */
class SidImplementationLicense
    extends stdClass
{
    /**
     *  
     * @return string
     * 
     * @access public
     */
    function toString ()
    {
        return "/**\n" . "<p>" .
        "MIT O.K.I&#46; SID Implementation License.\n" . "  <p>" .
        "	<b>Copyright and license statement:</b>\n" . "  </p>" . "  <p>" .
        "	Copyright &copy; 2002-2004 Massachusetts Institute of\n" .
        "	Technology\n" . "  </p>" . "  <p>" .
        "	This work is being provided by the copyright holder(s)\n" .
        "	subject to the terms of the O.K.I&#46; SID Implementation\n" .
        "	License. By obtaining, using and/or copying this Work,\n" .
        "	you agree that you have read, understand, and will comply\n" .
        "	with the O.K.I&#46; SID Implementation License. \n" . "  </p>" .
        "  <p>" . "	THE WORK IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY\n" .
        "	KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO\n" .
        "	THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A\n" .
        "	PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL\n" .
        "	MASSACHUSETTS INSTITUTE OF TECHNOLOGY, THE AUTHORS, OR\n" .
        "	COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR\n" .
        "	OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT\n" .
        "	OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH\n" .
        "	THE WORK OR THE USE OR OTHER DEALINGS IN THE WORK.\n" . "  </p>" .
        "  <p>" . "	<b>O.K.I&#46; SID Implementation License</b>\n" . "  </p>" .
        "  <p>" . "	This work (the &ldquo;Work&rdquo;), including software,\n" .
        "	documents, or other items related to O.K.I&#46; SID\n" .
        "	implementations, is being provided by the copyright\n" .
        "	holder(s) subject to the terms of the O.K.I&#46; SID\n" .
        "	Implementation License. By obtaining, using and/or\n" .
        "	copying this Work, you agree that you have read,\n" .
        "	understand, and will comply with the following terms and\n" .
        "	conditions of the O.K.I&#46; SID Implementation License:\n" .
        "  </p>" . "  <p>" .
        "	Permission to use, copy, modify, and distribute this Work\n" .
        "	and its documentation, with or without modification, for\n" .
        "	any purpose and without fee or royalty is hereby granted,\n" .
        "	provided that you include the following on ALL copies of\n" .
        "	the Work or portions thereof, including modifications or\n" .
        "	derivatives, that you make:\n" . "  </p>" . "  <ul>" . "	<li>" .
        "	  The full text of the O.K.I&#46; SID Implementation\n" .
        "	  License in a location viewable to users of the\n" .
        "	  redistributed or derivative work.\n" . "	</li>" . "  </ul>" .
        "  <ul>" . "	<li>" .
        "	  Any pre-existing intellectual property disclaimers,\n" .
        "	  notices, or terms and conditions. If none exist, a\n" .
        "	  short notice similar to the following should be used\n" .
        "	  within the body of any redistributed or derivative\n" .
        "	  Work: &ldquo;Copyright &copy; 2002-2004 Massachusetts\n" .
        "	  Institute of Technology. All Rights Reserved.&rdquo;\n" . "	</li>" .
        "  </ul>" . "  <ul>" . "	<li>" .
        "	  Notice of any changes or modifications to the\n" .
        "	  O.K.I&#46; Work, including the date the changes were\n" .
        "	  made. Any modified software must be distributed in such\n" .
        "	  as manner as to avoid any confusion with the original\n" .
        "	  O.K.I&#46; Work.\n" . "	</li>" . "  </ul>" . "  <p>" .
        "	THE WORK IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY\n" .
        "	KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO\n" .
        "	THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A\n" .
        "	PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL\n" .
        "	MASSACHUSETTS INSTITUTE OF TECHNOLOGY, THE AUTHORS, OR\n" .
        "	COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR\n" .
        "	OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT\n" .
        "	OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH\n" .
        "	THE WORK OR THE USE OR OTHER DEALINGS IN THE WORK.\n" . "  </p>" .
        "  <p>" . "	The name and trademarks of copyright holder(s) and/or\n" .
        "	O.K.I&#46; may NOT be used in advertising or publicity\n" .
        "	pertaining to the Work without specific, written prior\n" .
        "	permission. Title to copyright in the Work and any\n" .
        "	associated documentation will at all times remain with\n" .
        "	the copyright holders.\n" . "  </p>" . "  <p>" .
        "	The export of software employing encryption technology\n" .
        "	may require a specific license from the United States\n" .
        "	Government. It is the responsibility of any person or\n" .
        "	organization contemplating export to obtain such a\n" .
        "	license before exporting this Work.\n" . "  </p>" . "*/";
    }
}

?>