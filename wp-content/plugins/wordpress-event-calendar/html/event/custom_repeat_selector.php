<tr valign="top" id="spacerAboveRepeatFrequency">
                        <th colspan="2" scope="row">
                            <br/>
                        </th>
                    </tr>
                    <tr valign="top" id="repeatFrequency">
                        <th scope="row">
                            <label for="eventFrequency">
                                Repeat
                            </label>
                        </th>
                        <td>
                            <select name="eventFrequency" id="eventFrequency">
                                <option value="n" selected="selected">
                                    None
                                </option>
                                <option value="d">
                                    Every Day
                                </option>
                                <option value="w">
                                    Every Week
                                </option>
                                <option value="m">
                                    Every Month
                                </option>
                                <option value="y">
                                    Every Year
                                </option>
                                <option value="c">
                                    Custom
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top" id="customFrequencyRow" style="display: none;">
                        <th scope="row">
                            <label for="customFrequency">
                                Frequency:
                            </label>
                        </th>
                        <td>
                            <select name="customFrequency" id="customFrequency">
                                <option value="d">
                                    Daily
                                </option>
                                <option value="w" selected="selected">
                                    Weekly
                                </option>
                                <option value="m">
                                    Monthly
                                </option>
                                <option value="y">
                                    Yearly
                                </option>
                            </select>
                            <div class="yui-skin-sam" id="weekdaySelector" style="display: none;">
                                <br/>
                                Every 1 week(s) on: 
                                <br/>
                                <input id="sundayCheckbox" type="checkbox" name="sundayCheckbox" value="1">
                                <input id="mondayCheckbox" type="checkbox" name="mondayCheckbox" value="2">
                                <input id="tuesdayCheckbox" type="checkbox" name="tuesdayCheckbox" value="3">
                                <input id="wednesdayCheckbox" type="checkbox" name="wednesdayCheckbox" value="4">
                                <input id="thursdayCheckbox" type="checkbox" name="thursdayCheckbox" value="5">
                                <input id="fridayCheckbox" type="checkbox" name="fridayCheckbox" value="6">
                                <input id="saturdayCheckbox" type="checkbox" name="saturdayCheckbox" value="7">
                            </div>
                            <div class="yui-skin-sam" id="monthlySelector" style="display: none;">
                                <br/>
                                Every 1 month(s) on: 
                                <br/>
                                <label>
                                    <input type="radio" name="group1" value="multiple" id="multipleRadio" onchange="switchMonthSelector(); return false;" checked>
 each
                                </label>
                                <table>
                                    <?php 
                                    $numberOfDays = 1;
                                    for ($i = 0; $numberOfDays < 32; $i++)
                                    {
                                        echo '<tr>';
                                        for ($j = 0; $j < 7; $j++)
                                        {
                                            if ($numberOfDays < 32)
                                            {
                                                echo '<td>';
                                                echo '<input id="monthNumberSelector'.$numberOfDays.'" type="checkbox" name="monthNumberSelector[]" value="'.$numberOfDays.'" />';
                                                echo '</td>';
                                                
                                    ?>
                                    <?php 
                                    $numberOfDays++;
                                    }
                                    
                                    }
                                    echo '</tr>';
                                    }
                                    ?>
                                </table>
                                <br/>
                                <label>
                                    <input type="radio" name="group1" value="singular" id="singularRadio" onchange="switchMonthSelector(); return false;">
                                    On the:
                                </label>
                                <select name="singular_part1" id="singular_part1" disabled="true">
                                    <option value="1" label="first">
                                    </option>
                                    <option value="2" label="second">
                                    </option>
                                    <option value="3" label="third">
                                    </option>
                                    <option value="4" label="fourth">
                                    </option>
                                    <optgroup label="----------">
                                    </optgroup>
                                    <option value="l" label="last">
                                    </option>
                                </select>
                                <select name="singular_part2" id="singular_part2" disabled="true">
                                    <option value="sunday" label="Sunday">
                                    </option>
                                    <option value="monday" label="Monday">
                                    </option>
                                    <option value="tuesday" label="Tuesday">
                                    </option>
                                    <option value="wednesday" label="Wednesday">
                                    </option>
                                    <option value="thursday" label="Thursday">
                                    </option>
                                    <option value="friday" label="Friday">
                                    </option>
                                    <option value="saturday" label="Saturday">
                                    </option>
                                    <optgroup label="----------">
                                    </optgroup>
                                    <option value="day" label="Day">
                                    </option>
                                    <option value="weekday" label="Weekday">
                                    </option>
                                    <option value="weekendday" label="Weekend Day">
                                    </option>
                                </select>
                            </div>
                            <div class="yui-skin-sam" id="yearlySelector" style="display: none;">
                                <br/>
                                Every 1 year(s) in: 
                                <br/>
                                <table>
                                    <tr>
                                        <td>
                                            <input id="monthSelector1" type="checkbox" name="monthSelector[]" value="jan" />
                                        </td>
                                        <td>
                                            <input id="monthSelector2" type="checkbox" name="monthSelector[]" value="feb" />
                                        </td>
                                        <td>
                                            <input id="monthSelector3" type="checkbox" name="monthSelector[]" value="mar" />
                                        </td>
                                        <td>
                                            <input id="monthSelector4" type="checkbox" name="monthSelector[]" value="apr" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="monthSelector5" type="checkbox" name="monthSelector[]" value="may" />
                                        </td>
                                        <td>
                                            <input id="monthSelector6" type="checkbox" name="monthSelector[]" value="jun" />
                                        </td>
                                        <td>
                                            <input id="monthSelector7" type="checkbox" name="monthSelector[]" value="jul" />
                                        </td>
                                        <td>
                                            <input id="monthSelector8" type="checkbox" name="monthSelector[]" value="aug" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="monthSelector9" type="checkbox" name="monthSelector[]" value="sept" />
                                        </td>
                                        <td>
                                            <input id="monthSelector10" type="checkbox" name="monthSelector[]" value="oct" />
                                        </td>
                                        <td>
                                            <input id="monthSelector11" type="checkbox" name="monthSelector[]" value="nov" />
                                        </td>
                                        <td>
                                            <input id="monthSelector12" type="checkbox" name="monthSelector[]" value="dec" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>