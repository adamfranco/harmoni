<?php 
 
/**
 * <p>
 * MIT O.K.I&#46; SID Definition License.
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
 * terms of the O.K.I&#46; SID Definition     License. By obtaining, using
 * and/or copying this Work,     you agree that you have read, understand, and
 * will comply     with the O.K.I&#46; SID Definition License.
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
 * <b>O.K.I&#46; SID Definition License</b>
 * </p>
 * 
 * <p>
 * This work (the &ldquo;Work&rdquo;), including any     software, documents,
 * or other items related to O.K.I&#46;     SID definitions, is being provided
 * by the copyright     holder(s) subject to the terms of the O.K.I&#46; SID
 * Definition License. By obtaining, using and/or copying     this Work, you
 * agree that you have read, understand, and     will comply with the
 * following terms and conditions of     the O.K.I&#46; SID Definition
 * License:
 * </p>
 * 
 * <p>
 * You may use, copy, and distribute unmodified versions of     this Work for
 * any purpose, without fee or royalty,     provided that you include the
 * following on ALL copies of     the Work that you make or distribute:
 * </p>
 * 
 * <ul>
 * <li>
 * The full text of the O.K.I&#46; SID Definition License in a location
 * viewable to users of the redistributed Work.
 * </li>
 * </ul>
 * 
 * 
 * <ul>
 * <li>
 * Any pre-existing intellectual property disclaimers, notices, or terms and
 * conditions. If none exist, a short notice similar to the following should
 * be used within the body of any redistributed Work: &ldquo;Copyright &copy;
 * 2002-2004 Massachusetts Institute of Technology. All Rights
 * Reserved.&rdquo;
 * </li>
 * </ul>
 * 
 * <p>
 * You may modify or create Derivatives of this Work only     for your internal
 * purposes. You shall not distribute or     transfer any such Derivative of
 * this Work to any location     or any other third party. For purposes of
 * this license,     &ldquo;Derivative&rdquo; shall mean any derivative of the
 * Work as defined in the United States Copyright Act of     1976, such as
 * a translation or modification.
 * </p>
 * 
 * <p>
 * THE WORK PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE     WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR     PURPOSE AND NONINFRINGEMENT.
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
class SidLicense
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
        return "/**\n" . "  <p>" .
        "    MIT O.K.I&#46; SID Definition License.\n" . "  </p>" . "  <p>" .
        "	<b>Copyright and license statement:</b>\n" . "  </p>" . "  <p>" .
        "	Copyright &copy; 2002-2004 Massachusetts Institute of\n" .
        "	Technology\n" . "  </p>" . "  <p>" .
        "	This work is being provided by the copyright holder(s)\n" .
        "	subject to the terms of the O.K.I&#46; SID Definition\n" .
        "	License. By obtaining, using and/or copying this Work,\n" .
        "	you agree that you have read, understand, and will comply\n" .
        "	with the O.K.I&#46; SID Definition License.\n" . "  </p>" . "  <p>" .
        "	THE WORK IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY\n" .
        "	KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO\n" .
        "	THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A\n" .
        "	PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL\n" .
        "	MASSACHUSETTS INSTITUTE OF TECHNOLOGY, THE AUTHORS, OR\n" .
        "	COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR\n" .
        "	OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT\n" .
        "	OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH\n" .
        "	THE WORK OR THE USE OR OTHER DEALINGS IN THE WORK.\n" . "  </p>" .
        "  <p>" . "	<b>O.K.I&#46; SID Definition License</b>\n" . "  </p>" .
        "  <p>" . "	This work (the &ldquo;Work&rdquo;), including any\n" .
        "	software, documents, or other items related to O.K.I&#46;\n" .
        "	SID definitions, is being provided by the copyright\n" .
        "	holder(s) subject to the terms of the O.K.I&#46; SID\n" .
        "	Definition License. By obtaining, using and/or copying\n" .
        "	this Work, you agree that you have read, understand, and\n" .
        "	will comply with the following terms and conditions of\n" .
        "	the O.K.I&#46; SID Definition License:\n" . "  </p>" . "  <p>" .
        "	You may use, copy, and distribute unmodified versions of\n" .
        "	this Work for any purpose, without fee or royalty,\n" .
        "	provided that you include the following on ALL copies of\n" .
        "	the Work that you make or distribute:\n" . "  </p>" . "  <ul>" .
        "	<li>" .
        "	  The full text of the O.K.I&#46; SID Definition License\n" .
        "	  in a location viewable to users of the redistributed\n" .
        "	  Work.\n" . "	</li>" . "  </ul>" . "  <ul>" . "	<li>" .
        "	  Any pre-existing intellectual property disclaimers,\n" .
        "	  notices, or terms and conditions. If none exist, a\n" .
        "	  short notice similar to the following should be used\n" .
        "	  within the body of any redistributed Work:\n" .
        "	  &ldquo;Copyright &copy; 2002-2004 Massachusetts Institute of\n" .
        "	  Technology. All Rights Reserved.&rdquo;\n" . "	</li>" . "  </ul>" .
        "  <p>" . "	You may modify or create Derivatives of this Work only\n" .
        "	for your internal purposes. You shall not distribute or\n" .
        "	transfer any such Derivative of this Work to any location\n" .
        "	or any other third party. For purposes of this license,\n" .
        "	&ldquo;Derivative&rdquo; shall mean any derivative of the\n" .
        "	Work as defined in the United States Copyright Act of\n" .
        "	1976, such as a translation or modification.\n" . "  </p>" . "  <p>" .
        "	THE WORK PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND,\n" .
        "	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE\n" .
        "	WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR\n" .
        "	PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL\n" .
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
        "	license before exporting this Work.\n" . "  </p>\n" . "*/";
    }
}

?>